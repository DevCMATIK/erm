<?php

namespace App\Http;

use App\App\Controllers\Controller;
use App\Domain\Client\CheckPoint\CheckPoint;
use App\Domain\WaterManagement\Device\Device;
use App\Domain\WaterManagement\Device\Sensor\Electric\ElectricityConsumption;
use App\Domain\WaterManagement\Device\Sensor\Sensor;
use Carbon\Carbon;
use Illuminate\Http\Request;


class TestController extends Controller
{


    public function __invoke(Request $request)
    {
        $time_start = microtime(true);

        $checkPoints = CheckPoint::whereNotNull('work_code')->where('dga_report',1)->get();
        $registros = array();
        foreach($checkPoints as $checkPoint) {
            $device = Device::with([
                'sensors' => function ($q) {
                    return $q->sensorType('totalizador');
                },
                'sensors.type',
                'sensors.analogous_reports' => function($q)
                {
                    $q->orderBy('id', 'desc')->first();
                }
            ])->whereHas('sensors', function ($q) {
                return $q->sensorType('totalizador');
            })->where('check_point_id',$checkPoint->id)->first();
            $totalizador = $device->sensors->first()->analogous_reports->first()->result;

            $flow = Device::with([
                'sensors' => function ($q) {
                    return $q->sensorType('tx-caudal');
                },
                'sensors.type',
                'sensors.analogous_reports' => function($q)
                {
                    $q->orderBy('id', 'desc')->first();
                }
            ])->whereHas('sensors', function ($q) {
                return $q->sensorType('tx-caudal');
            })->where('check_point_id',$checkPoint->id)->first();
            $caudal = $flow->sensors->first()->analogous_reports->first()->result;



            $device = Device::with([
                'sensors' => function ($q) {
                    return $q->sensorType('tx-nivel');
                },
                'sensors.type',
                'sensors.analogous_reports' => function($q)
                {
                    $q->orderBy('id', 'desc')->first();
                }
            ])->whereHas('sensors', function ($q) {
                return $q->sensorType('tx-nivel');
            })->where('check_point_id',$checkPoint->id)->first();
            $nivel = $device->sensors->first()->analogous_reports->first()->result * -1;
            array_push($registros,[
                'totalizador' => $totalizador,
                'nivel' => $nivel,
                'caudal' => $caudal,
                'device' => $device
            ]);
            //$this->ReportToDGA($totalizador,$caudal,$nivel,$checkPoint->work_code,$checkPoint);
        }
        $time_end = microtime(true);


        $execution_time = ($time_end - $time_start);
        dd($execution_time,$checkPoints,$registros);
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
