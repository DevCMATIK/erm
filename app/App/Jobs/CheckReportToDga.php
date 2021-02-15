<?php

namespace App\App\Jobs;

use App\App\Traits\ERM\HasAnalogousData;
use App\Domain\Client\CheckPoint\CheckPoint;
use App\Domain\Client\CheckPoint\DGA\CheckPointReport;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CheckReportToDga implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels,HasAnalogousData;

    public $dga_report;

    public function __construct($dga_report)
    {
        $this->dga_report = $dga_report;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $check_points =   CheckPoint::with('last_report')->whereNotNull('work_code')
            ->where('dga_report',$this->dga_report)
            ->get();
        foreach($check_points as $check_point) {
            if (Carbon::parse($check_point->last_report->report_date)->hour != now()->hour || $check_point->last_report->response != 0) {
                if($check_point->last_report->response != 0) {
                    CheckPointReport::find($check_point->last_report->id)->delete();
                }
                $sensors = $this->getSensors($check_point);
                $tote = $this->getToteSensor($sensors);
                $flow = $this->getFlowSensor($sensors);
                $level = $this->getLevelSensor($sensors);
                if($tote && $flow && $level) {
                    SendToDGA::dispatch($this->getAnalogousValue($tote,true),
                        $this->getAnalogousValue($flow,true),
                        ($this->getAnalogousValue($level,true) * -1),
                        $check_point->work_code,
                        $check_point)->onQueue('long-running-queue-low');
                } else {
                    continue;
                }
            }
        }
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
