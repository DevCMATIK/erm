<?php

namespace App\Http\Data\Jobs\Average;

use App\Domain\WaterManagement\Device\Sensor\Behavior\SensorBehavior;
use App\Domain\WaterManagement\Device\Sensor\Sensor;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class BackupSensorAverages implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $pointer;
    public $average;

    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $sensors = $this->getSensors();
        $toInsert = array();
        foreach ($sensors as $sensor) {
            $this->average = $sensor->average->last_average;
            $this->pointer = $sensor->average->pointer_date;
            foreach ($sensor->analogous_reports as $report) {
                $this->checkPointer($sensor,$report);
                $value = (float)number_format(($sensor->max_value + (float)$report->result),2);
                if($value < 0 && $value > $sensor->max_value) {
                    if ($value >= $this->average) {
                        $dynamic = null;
                        $static = $value;
                    } else {
                        $dynamic = $value;
                        $static = null;
                    }
                    array_push($toInsert,[
                        'sensor_id' => $sensor->id,
                        'dynamic_level' => $dynamic,
                        'static_level' => $static,
                        'current_average' => $this->average,
                        'date' => $report->date
                    ]);
                }
            }
        }

        SensorBehavior::insert($toInsert);
    }

    protected function getSensors()
    {
        return Sensor::with([
            'average',
            'behaviors' => function($q){
                return $q->orderBy('id','desc')->first();
            },
            'analogous_reports' => function($q) {
                return $q->whereRaw('`date` >= "'.Carbon::now()->subMinutes(5)->toDateTimeString().'"');
            },
            'type' => function ($q) {
                return $q->where('slug','tx-nivel');
            },
        ])->whereHas('type', function ($q) {
            return $q->where('slug','tx-nivel');
        })->has('average')->whereHas('analogous_reports')->get();
    }

    protected function checkPointer($sensor,$report)
    {
        if(Carbon::parse($this->pointer)->diffInSeconds(Carbon::parse($report->date)) > (60*60*6)) {

            $this->setAveragePointerDate($sensor,$report->date);
            $newAvg = $this->calculateLastAverage($report);
            $this->average  = $newAvg;
            $this->setLastAverage($sensor);
            $this->pointer = $report->date;
        }
    }

    protected function calculateLastAverage($report)
    {
        $records = SensorBehavior::with('sensor')->where('sensor_id',$report->sensor_id)
            ->whereBetween('date',[
                $this->pointer,
                $report->date
            ])->get();

        $dynamicAvg = $records->filter(function($item){
            return $item->dynamic_level != null;
        })->avg('dynamic_level');
        $staticAvg = $records->filter(function($item){
            return $item->static_level != null;
        })->avg('static_level');
        if(number_format(((($dynamicAvg - $staticAvg)/2) -($dynamicAvg)),3) == 0) {
            $newAvg = $this->average;
        } else {
            $newAvg = (number_format(((($dynamicAvg - $staticAvg)/2) -($dynamicAvg)),3) * -1);
        }
        return $newAvg;
    }



    protected function setAveragePointerDate($sensor,$pointer)
    {
        $sensor->average()->update(['pointer_date' => $pointer]);
    }

    protected function setLastAverage($sensor)
    {
        $sensor->average()->update(['last_average' => $this->average]);
    }


}
