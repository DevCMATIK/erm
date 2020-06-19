<?php

namespace App\Http\Client\CheckPoint\Controllers;

use App\Domain\Client\CheckPoint\Indicator\CheckPointIndicator;
use App\Domain\WaterManagement\Device\Sensor\Chronometer\SensorChronometer;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;

class CheckPointIndicatorsController extends Controller
{
    public function getIndicators($check_point_id)
    {
        $indicators = CheckPointIndicator::with(['chronometer','chronometer_to_compare'])->where('check_point_id',$check_point_id)->get();
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

                if($group->chronometer_to_compare) {
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
                                $value = number_format($value,1);
                            }
                        } else {
                            $value = 0;
                        }
                        $suffix = '%';

                        break;
                    case 'hour-meter':
                        if($chronometer) {
                            $value = $chronometer->trackings->sum('diff_in_hours');
                            $value = number_format($value,0);
                        } else {
                            $value = 0;
                        }
                        $suffix = 'Hrs.';
                        break;
                    default:
                        if(!$chronometer) {
                            $value = 0;
                        } else {
                            $value = count($chronometer->trackings);
                        }
                        $suffix = '';
                        break;
                }
                array_push($indicatorsArray[$groupName],[
                    'name' => $group->name,
                    'frame' => $name,
                    'value' => $value,
                    'suffix' => $suffix
                ]);
            }
        }

        return $indicatorsArray;
    }
}
