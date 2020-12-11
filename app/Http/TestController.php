<?php

namespace App\Http;

use App\App\Controllers\Controller;
use App\App\Traits\ERM\HasAnalogousData;
use App\Domain\Client\CheckPoint\CheckPoint;
use App\Domain\Client\CheckPoint\DGA\CheckPointReport;
use App\Domain\Client\Zone\Sub\SubZone;
use App\Domain\Client\Zone\Zone;
use App\Domain\System\User\User;
use App\Domain\WaterManagement\Device\Device;
use App\Domain\WaterManagement\Device\Sensor\Electric\ElectricityConsumption;
use App\Domain\WaterManagement\Device\Sensor\Sensor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Sentinel;


class TestController extends Controller
{
    use HasAnalogousData;

    public function __invoke()
    {
        $time_start = microtime(true);

        $checkPoints = CheckPoint::whereNotNull('work_code')->where('dga_report',1)->get();
        $reports = array();
        foreach($checkPoints as $checkPoint) {

            $last_report = '';
            $last_report = CheckPointReport::where('check_point_id',$checkPoint->id)->orderBy('id','desc')->first();
            if(Carbon::now()->diffInMinutes(Carbon::parse($last_report->report_date)) > 40) {
                $device = Device::with([
                    'sensors' => function ($q) {
                        return $q->sensorType('totalizador');
                    },
                    'sensors.type',
                    'sensors.analogous_reports' => function($q)
                    {
                        $q->orderBy('id', 'desc')->take(1);
                    }
                ])->whereHas('sensors', function ($q) {
                    return $q->sensorType('totalizador');
                })->where('check_point_id',$checkPoint->id)->first();
                if(!$device || !$device->sensors->first()) {
                    dd($device->sensors->first());
                } else {
                    $totalizador = $device->sensors->first()->analogous_reports->first()->result;
                }

                $flow = Device::with([
                    'sensors' => function ($q) {
                        return $q->sensorType('tx-caudal');
                    },
                    'sensors.type',
                    'sensors.analogous_reports' => function($q)
                    {
                        $q->orderBy('id', 'desc')->take(1);
                    }
                ])->whereHas('sensors', function ($q) {
                    return $q->sensorType('tx-caudal');
                })->where('check_point_id',$checkPoint->id)->first();
                if(!$flow || !$flow->sensors->first()) {
                    dd($flow->sensors->first());
                } else {
                    $caudal = $flow->sensors->first()->analogous_reports->first()->result;
                }




                $device = Device::with([
                    'sensors' => function ($q) {
                        return $q->sensorType('tx-nivel');
                    },
                    'sensors.type',
                    'sensors.analogous_reports' => function($q)
                    {
                        $q->orderBy('id', 'desc')->take(1);
                    }
                ])->whereHas('sensors', function ($q) {
                    return $q->sensorType('tx-nivel');
                })->where('check_point_id',$checkPoint->id)->first();
                if(!$device || !$device->sensors->first()) {
                    dd($device->sensors->first());
                } else {
                    $nivel = $device->sensors->first()->analogous_reports->first()->result * -1;
                }

                array_push($reports,[
                    'totalizador' => $totalizador,
                    'caudal' => $caudal,
                    'nivel' => $nivel,
                    'work_code' => $checkPoint->work_code,
                    'punto_control' => $checkPoint
                ]);
            }

        }

        $time_end = microtime(true);

        $execution_time = ($time_end - $time_start);

        dd($execution_time,$reports);

    }



}
