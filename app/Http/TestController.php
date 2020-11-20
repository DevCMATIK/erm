<?php

namespace App\Http;

use App\App\Controllers\Controller;
use App\Domain\Client\CheckPoint\CheckPoint;
use App\Domain\Client\CheckPoint\Indicator\CheckPointIndicator;
use App\Domain\Client\Zone\Sub\SubZone;
use App\Domain\Client\Zone\Zone;
use App\Domain\WaterManagement\Device\Sensor\Alarm\SensorAlarmLog;
use App\Domain\WaterManagement\Device\Sensor\Chronometer\ChronometerTracking;
use App\Domain\WaterManagement\Device\Sensor\Electric\ElectricityConsumption;
use App\Domain\WaterManagement\Device\Sensor\Sensor;
use App\Domain\WaterManagement\Device\Sensor\Trigger\SensorTrigger;
use App\Domain\WaterManagement\Main\Report;
use App\Http\Data\Jobs\CheckPoint\ReportToDGA;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Sentinel;


class TestController extends Controller
{


    public function __invoke(Request $request)
    {
        $time_start = microtime(true);
        for($i=$request->from;$i<($request->max_days+1);$i++){
            $toInsert = array();
            $month = str_pad($request->month, 2, '0', STR_PAD_LEFT);
            $day = str_pad($i, 2, '0', STR_PAD_LEFT);
            $sensors = $this->getSensors("2020-{$month}-{$day}");
            foreach($sensors as $sensor) {
                if(!$sensor->consumptions()->whereDate('date',"2020-{$month}-{$day}")->first()) {
                    if(count($sensor->consumptions) > 0) {
                        $first_read = $sensor->consumptions->sortByDesc('date')->first()->last_read;
                        $last_read = $sensor->analogous_reports->sortByDesc('date')->first()->result;
                    } else {
                        $first_read = $sensor->analogous_reports->sortBy('date')->first()->result;
                        $last_read = $sensor->analogous_reports->sortByDesc('date')->first()->result;
                    }

                    if($first_read != '' && $last_read != '') {
                        $consumption = $last_read - $first_read;

                        array_push($toInsert,[
                            'sensor_id' => $sensor->id,
                            'first_read' => $first_read,
                            'last_read' => $last_read,
                            'consumption' => $consumption,
                            'sensor_type' => $sensor->type->slug,
                            'sub_zone_id' => $sensor->device->check_point->sub_zones->first()->id,
                            'date' => "2020-{$month}-{$day}"
                        ]);
                    }


                }


            }
            if(count($toInsert) > 0) {
                ElectricityConsumption::insert($toInsert);
            }

        }
        $time_end = microtime(true);


        $execution_time = ($time_end - $time_start);
        dd($execution_time,ElectricityConsumption::count());
    }

    protected function getAnalogousValue($trigger)
    {
        $sensor_address = $trigger->sensor->full_address;
        $sensor_grd_id = $trigger->sensor->device->internal_id;
        $disposition = $trigger->sensor->dispositions()->where('id',$trigger->sensor->default_disposition)->first();
        if(!$disposition) {
            $disposition = $trigger->sensor->dispositions()->first();
        }
        if($disposition) {
            $valorReport = Report::where('grd_id',$sensor_grd_id)->first()->$sensor_address;
            if($valorReport){
                $ingMin = $disposition->sensor_min;
                $ingMax = $disposition->sensor_max;
                $escalaMin = $disposition->scale_min;
                $escalaMax = $disposition->scale_max;
                if($escalaMin == null && $escalaMax == null) {
                    $data = ($ingMin * $valorReport) + $ingMax;
                } else {
                    $f1 = $ingMax - $ingMin;
                    $f2 = $escalaMax - $escalaMin;
                    $f3 = $valorReport - $escalaMin;
                    if($f2 == 0) {
                        $data = ((0)*($f3)) + $ingMin ;
                    } else {
                        $data = (($f1/$f2)*($f3)) + $ingMin ;
                    }
                }

            }
            if(isset($data)) {
                return $data;
            }
        }

        return false;


    }

    protected function getReceptorValue($trigger)
    {
        $sensor_address = $trigger->receptor->full_address;
        $sensor_grd_id = $trigger->receptor->device->internal_id;

        $report = Report::where('grd_id',$sensor_grd_id)->first();
        return  $report->$sensor_address;
    }

}
