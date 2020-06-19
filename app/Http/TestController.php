<?php

namespace App\Http;

use App\App\Controllers\Controller;
use App\Domain\Client\CheckPoint\Indicator\CheckPointIndicator;
use App\Domain\WaterManagement\Device\Sensor\Chronometer\ChronometerTracking;
use App\Domain\WaterManagement\Device\Sensor\Chronometer\SensorChronometer;
use App\Domain\WaterManagement\Device\Sensor\Electric\ElectricityConsumption;
use App\Domain\WaterManagement\Device\Sensor\Sensor;
use Carbon\Carbon;
use Illuminate\Http\Request;


class TestController extends Controller
{


    public function __invoke(Request $request)
    {

        $indicators = CheckPointIndicator::with(['check_point','chronometer','chronometer_to_compare'])->get();
        $indicatorsArray = array();
        foreach ($indicators->groupBy('group') as $groups) {
            $groupName = $groups->first()->group_name;
            $indicatorsArray[$groupName] = array();
            foreach ($groups as $group) {
                $chronometer = SensorChronometer::whereHas('trackings',$filter =  function($query) use($group){
                    switch($group->frame) {
                        case 'this-week':
                            $query->whereNotNull('end_date')->thisWeek('start_date');
                            break;
                        case 'last-week':
                            $query->whereNotNull('end_date')->lastWeek('start_date');
                            break;
                        default:
                            $query->whereNotNull('end_date')->today('start_date');
                            break;
                    }
                })->with([
                    'trackings' => $filter
                ])->find($group->chronometer_id);

                if($group->to_compare_sensor) {
                    $toCompare = SensorChronometer::whereHas('trackings',$filter =  function($query) use($group){
                        switch($group->frame) {
                            case 'this-week':
                                $query->whereNotNull('end_date')->thisWeek('start_date');
                                break;
                            case 'last-week':
                                $query->whereNotNull('end_date')->lastWeek('start_date');
                                break;
                            default:
                                $query->whereNotNull('end_date')->today('start_date');
                                break;
                        }
                    })->with([
                        'trackings' => $filter
                    ])->find($group->chronometer_to_compare);
                }
                switch($group->frame) {
                    case 'this-week':
                        $name = 'Esta semana';
                        break;
                    case 'last-week':
                        $name = 'Semana pasada';
                        break;
                    default:
                        $name = 'Hoy';
                        break;
                }
                switch ($group->type) {
                    case  'simple-rule-of-three':
                        if($chronometer && $toCompare) {
                            $measurement = 'diff_in_'.$group->measurement;
                            $val = $chronometer->trackings->sum($measurement);
                            $toCompareVal = $toCompare->trackings->sum($measurement);
                            if($val === 0 || $toCompareVal === 0) {
                                $value = 0;
                            } else {
                                $value = $toCompareVal * 100 / $val;
                            }
                        } else {
                            $value = 0;
                        }


                        break;
                    default:
                        if(!$chronometer) {
                            $value = 0;
                        } else {
                            $value = count($chronometer->trackings);
                        }
                        break;
                }
                array_push($indicatorsArray[$groupName],[
                        'nombre' => $group->name,
                        'intervalo' => $name,
                        'value' => $value
                ]);
            }
        }

        return json_encode($indicatorsArray,JSON_PRETTY_PRINT);
    }

    protected function getSensors($date)
    {

    }
}
