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
        $tote = array();
        $flow = array();
        $level = array();
        foreach($checkPoints as $checkPoint)
        {
            if(!isset($checkPoint->last_report) || $this->calculateTimeSinceLastReport($checkPoint) > 40) {
                $sensors = $this->getSensors($checkPoint);
                if(count($sensors) == 3) {
                    $tote[] = $this->getAnalogousValue($sensors->where('name','Aporte')->first(),true);
                    $flow[] = $this->getAnalogousValue($sensors->where('name','Caudal')->first(),true);
                    $level[] = $this->getAnalogousValue($sensors->where('name','Nivel')->first(),true);
                } else {
                    continue;
                }
            }
        }



        $time_end = microtime(true);

        $execution_time = ($time_end - $time_start);

        dd($execution_time,$tote,$flow,$level);

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

    protected function getSensors($checkPoint)
    {
        return $this->getSensorsByCheckPoint($checkPoint->id)
            ->whereIn('name',['Nivel','Aporte','Caudal'])
            ->get();
    }



}
