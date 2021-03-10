<?php

namespace App\Http\WaterManagement\Dashboard\CheckPoint\Kpi;

use App\Domain\Client\CheckPoint\CheckPoint;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;

class CheckPointCostKpiController extends Controller
{
    public function getCostKpi($check_points,$fromCheckpoint = false)
    {
        $data = array();
        $checkPoints = CheckPoint::with('consumptions')->has('consumptions')->find(explode(',',$check_points))->filter(function($item){
            return $item->hour_consumption <= 0;
        });
        foreach($checkPoints as $checkPoint) {
            $last = optional($checkPoint->consumptions)->sortByDesc('date')->first();

            if($fromCheckpoint) {
                $name = 'Costo M3 -> kWh';
            } else {
                $name = $checkPoint->name;
            }
            array_push($data,[
                'check_point' => $name,
                'average_cost' => optional($checkPoint->consumptions)->avg('hour_consumption'),
                'last_hour_cost' => optional($last)->hour_consumption,
                'last_hour_input' => optional($last)->water_input,
                'last_hour_energy' => optional($last)->active_energy,

            ]);
        }
        return $data;
    }
}
