<?php

namespace App\Http\WaterManagement\Dashboard\CheckPoint\Kpi;

use App\Domain\Client\CheckPoint\CheckPoint;
use App\Domain\Client\CheckPoint\Flow\CheckPointAuthorizedFlow;
use App\Domain\Client\CheckPoint\Flow\CheckPointFlow;
use App\Domain\WaterManagement\Device\Device;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;

class CheckPointKpiController extends Controller
{
    public function getFlowKpi($check_point_id)
    {
        $device = Device::with([
            'check_point',
            'sensors' => function($q) {
                return $q->sensorType('tx-caudal');
            },
            'sensors.type',
            'sensors.today_analogous_reports'
        ])->where('check_point_id',$check_point_id)->whereHas('sensors', function($q){
            return $q->sensorType('tx-caudal');
        })->first();
        if($device){
            $flow_today = $device->sensors->first()->today_analogous_reports->avg('result');
            $flow_check_point = CheckPoint::with([
                'authorized_flow',
                'flow_averages'
            ])->find($check_point_id);
            $flow_yesterday = optional($flow_check_point->flow_averages()->yesterday('date')->first())->average_flow;
            $flow_lastWeek = $flow_check_point->flow_averages()->lastWeek('date')->get()->avg('average_flow');
            $flow_lastMonth = $flow_check_point->flow_averages()->lastMonth('date')->get()->avg('average_flow');
            if($flow_check_point->authorized_flow) {
                $flow_percent = $flow_today * 100 / $flow_check_point->authorized_flow->authorized_flow;
            } else {
                $flow_percent = null;
            }
            return compact('flow_today','flow_yesterday','flow_check_point','flow_percent','flow_lastWeek','flow_lastMonth');

        } else {
            return false;
        }
       }

    public function getTotalizerKpi($check_point_id)
    {
        $device = Device::with([
            'check_point.totalizers',
            'sensors' => function ($q) {
                return $q->sensorType('totalizador');
            },
            'sensors.type',
            'sensors.today_analogous_reports'
        ])->where('check_point_id',$check_point_id)->whereHas('sensors', function ($q) {
            return $q->sensorType('totalizador');
        })->first();

        if($device){
            $first_read = optional($device->sensors->first()->today_analogous_reports->first())->result;
            $last_read = optional($device->sensors->first()->today_analogous_reports->sortByDesc('id')->first())->result;
            if(!$first_read && !$last_read) {
                return false;
            }
            $today = $last_read - $first_read;
            $total = $last_read;
            $check_point = CheckPoint::with([
                'totalizers'
            ])->find($check_point_id);
            $yesterday = optional($check_point->totalizers()->yesterday('date')->first())->input;
            $lastWeek = $check_point->totalizers()->lastWeek('date')->get()->sum('input');
            $lastMonth = $check_point->totalizers()->lastMonth('date')->get()->sum('input');

            return compact('today','total','yesterday','check_point','lastWeek','lastMonth');

        } else {
            return false;
        }
    }
}
