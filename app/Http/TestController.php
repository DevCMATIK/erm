<?php

namespace App\Http;

use App\App\Controllers\Soap\SoapController;
use App\App\Jobs\SendToDGA;
use App\App\Traits\ERM\HasAnalogousData;
use App\Domain\Client\CheckPoint\CheckPoint;
use App\Domain\Client\CheckPoint\DGA\CheckPointReport;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Sentinel;


class TestController extends SoapController
{
    use HasAnalogousData;

    public $current_date = '2020-12-01';

    public function __invoke()
    {
        return view('test.view');
    }

    protected function another()
    {
        $checkPoint = CheckPoint::with('last_report')->find(242);
        if(!isset($checkPoint->last_report) || $this->calculateTimeSinceLastReport($checkPoint) > 28) {
            $sensors = $this->getSensors($checkPoint);
            $tote = $this->getToteSensor($sensors);
            $flow = $this->getFlowSensor($sensors);
            $level = $this->getLevelSensor($sensors);
            if($tote && $flow && $level) {
                SendToDGA::dispatch($this->getAnalogousValue($tote,true),
                    $this->getAnalogousValue($flow,true),
                    ($this->getAnalogousValue($level,true) * -1),
                    $checkPoint->work_code,
                    $checkPoint)->onQueue('long-running-queue-low');

            }
        }
    }
    protected function calculateTimeSinceLastReport($check_point)
    {
        return Carbon::now()->diffInMinutes(Carbon::parse($check_point->last_report->report_date));
    }

    protected function getSensors($checkPoint)
    {
        return $this->getSensorsByCheckPoint($checkPoint->id)
            ->whereIn('type_id',function($query){
                $query->select('id')->from('sensor_types')
                    ->where('is_dga',1)
                    ->whereIn('sensor_type',[
                        'tote',
                        'level',
                        'flow',
                    ]);
            })->get();
    }

    protected function getLevelSensor($sensors)
    {
        return $sensors->filter(function($sensor) {
            return collect(['level'])->contains($sensor->type->sensor_type);
        })->first();
    }

    protected function getToteSensor($sensors)
    {
        return $sensors->filter(function($sensor) {
            return collect(['tote'
            ])->contains($sensor->type->sensor_type);
        })->first();

    }

    protected function getFlowSensor($sensors)
    {
        return $sensors->filter(function($sensor) {
            return collect(['flow'
            ])->contains($sensor->type->sensor_type);
        })->first();

    }
}
