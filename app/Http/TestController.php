<?php

namespace App\Http;

use App\App\Controllers\Controller;
use App\Domain\Client\CheckPoint\Indicator\CheckPointIndicator;
use App\Domain\WaterManagement\Device\Sensor\Chronometer\ChronometerTracking;
use App\Domain\WaterManagement\Device\Sensor\Electric\ElectricityConsumption;
use App\Domain\WaterManagement\Device\Sensor\Sensor;
use Carbon\Carbon;
use Illuminate\Http\Request;


class TestController extends Controller
{


    public function __invoke(Request $request)
    {

        $indicators = CheckPointIndicator::with(['check_point','sensor','sensor_to_compare'])->get();
        $indicatorsArray = array();
        foreach ($indicators->groupBy('group') as $groups) {
            $groupName = $groups->first()->group_name;
            foreach ($groups as $group) {
                $sensor = Sensor::whereHas('chronometers',$filter =  function($query) use($group){
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
                    'chronometers' => $filter
                ])->find($group->sensor_id);

                if($group->to_compare_sensor) {
                    $toCompare = Sensor::whereHas('chronometers',$filter =  function($query) use($group){
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
                        'chronometers' => $filter
                    ])->find($group->to_compare_sensor);
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
                        $measurement = 'diff_in_'.$group->measurement;
                        $val = $sensor->chronometers->sum($measurement);
                        $toCompareVal = $toCompare->chronometers->sum($measurement);
                        if($val === 0 || $toCompareVal === 0) {
                            $value = 0;
                        } else {
                            $value = $toCompareVal * 100 / $val;
                        }

                        break;
                    default:
                        $value = $sensor->chronometers->count();
                        break;
                }
                array_push($indicatorsArray[$groupName]['indicadores'],[
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
