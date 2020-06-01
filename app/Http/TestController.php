<?php

namespace App\Http;

use App\App\Controllers\Controller;
use App\Domain\WaterManagement\Device\Sensor\Electric\ElectricityConsumption;
use App\Domain\WaterManagement\Device\Sensor\Sensor;
use Carbon\Carbon;
use Illuminate\Http\Request;


class TestController extends Controller
{

    public function __invoke(Request $request)
    {
        $time_start = microtime(true);

        for($i=$request->from;$i<$request->max_days;$i++){
            $toInsert = array();
            $month = str_pad($request->month, 2, '0', STR_PAD_LEFT);
            $day = str_pad($i, 2, '0', STR_PAD_LEFT);
            $sensors = $this->getSensors("2020-{$month}-{$day}");
            foreach($sensors as $sensor) {
                if(count($sensor->consumptions) > 0) {
                    $first_read = $sensor->consumptions->sortByDesc('date')->first()->last_read;
                    $last_read = $sensor->analogous_reports->sortByDesc('date')->first()->result;
                } else {
                    $first_read = $sensor->analogous_reports->sortBy('date')->first()->result;
                    $last_read = $sensor->analogous_reports->sortByDesc('date')->first()->result;
                }

                if($first_read != '' && $last_read != '') {
                    $consumption = $last_read - $first_read;
                    if(!$sensor->consumptions()->whereDate('date',"2020-{$month}-{$day}")->first()) {
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

    protected function getSensors($date)
    {
        $first_date = Carbon::parse($date)->toDateString();
        $second_date = Carbon::parse($date)->addDay()->toDateString();
        return  Sensor::whereHas('type', $typeFilter = function ($q) {
            return $q->where('slug','ee-e-activa')->orWhere('slug','ee-e-reactiva')->orWhere('slug','ee-e-aparente');
        })->whereHas('analogous_reports', $reportsFilter = function($query) use ($first_date,$second_date){
            return $query->whereRaw("analogous_reports.date between '{$first_date} 00:00:00' and '{$second_date} 00:01:00'");
        })->with([
            'type' => $typeFilter,
            'device.check_point.sub_zones',
            'analogous_reports' => $reportsFilter,
            'consumptions'
        ])->get();
    }
}
