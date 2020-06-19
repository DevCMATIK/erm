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
        $trackings = ChronometerTracking::whereNotNull('end_date')->whereNull('diff_in_seconds')->get();
        foreach($trackings as $tracking) {
            $tracking->diff_in_seconds = Carbon::parse($tracking->end_date)->diffInSeconds(Carbon::parse($tracking->start_date));
            $tracking->diff_in_minutes = Carbon::parse($tracking->end_date)->diffInMinutes(Carbon::parse($tracking->start_date));
            $tracking->diff_in_hours = Carbon::parse($tracking->end_date)->diffInHours(Carbon::parse($tracking->start_date));
            $tracking->save();
        }
        dd($trackings);
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
                        $value = $toCompareVal * 100 / $val;
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
    }

    protected function getSensors($date)
    {

    }
}
