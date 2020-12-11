<?php

namespace App\Http;

use App\App\Controllers\Controller;
use App\App\Traits\ERM\HasAnalogousData;
use App\Domain\Client\CheckPoint\CheckPoint;
use App\Domain\WaterManagement\Device\Device;
use Carbon\Carbon;
use Sentinel;


class TestController extends Controller
{
    use HasAnalogousData;

    public function __invoke()
    {
        $time_start = microtime(true);

        $checkPoints = $this->getCheckPoints(1);
        $sensors = array();
        $chk = array();
        foreach($checkPoints as $checkPoint)
        {
            if(!isset($checkPoint->last_report) || $this->calculateTimeSinceLastReport($checkPoint) > 40) {
                $sensors[] = $this->getSensorsByCheckPoint($checkPoint->id)->whereIn('name',['Nivel','Aporte','Caudal'])->get()->toArray();

                $chk[] = $this->getSensorsByCheckPoint($checkPoint->id)->whereIn('name',['Nivel','Aporte','Caudal'])->first()->device->check_point_id;
            }
        }



        $time_end = microtime(true);

        $execution_time = ($time_end - $time_start);

        dd($execution_time,$checkPoints,$sensors, array_diff($chk,$checkPoints->pluck('id')->toArray()));

    }

    protected function getCheckPoints($dga_report)
    {
        return  CheckPoint::with('last_report')
                    ->whereNotNull('work_code')
                    ->where('dga_report',1)
                    ->get();
    }

    protected function calculateTimeSinceLastReport($check_point)
    {
        return Carbon::now()->diffInMinutes(Carbon::parse($check_point->last_report->report_date));
    }

    protected function getDevice($check_point)
    {
        return Device::with([
            'sensors' => function ($q) {
                return $q->sensorType('totalizador');
            },
            'sensors.address',
            'sensors.type',
            'sensors.dispositions',

        ])->whereHas('sensors', function ($q) {
            return $q->sensorType('totalizador');
        })->where('check_point_id',$check_point->id)->first();
    }



}
