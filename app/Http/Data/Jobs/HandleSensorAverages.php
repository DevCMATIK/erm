<?php

namespace App\Http\Data\Jobs;

use App\Domain\Data\Analogous\AnalogousReport;
use App\Domain\WaterManagement\Device\Sensor\Behavior\SensorBehavior;
use App\Domain\WaterManagement\Device\Sensor\Sensor;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class HandleSensorAverages implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $chunk, $pointer,$sensor,$average;

    public function __construct($chunk)
    {
        $this->chunk = $chunk;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->sensor = Sensor::with('average')->find($this->chunk->first()->sensor_id);
        $this->pointer = $this->getPointerDate();

        $toInsert = array();
        foreach ($this->chunk as $report) {
            $this->checkPointer($report);
            $value = (float)number_format(($this->sensor->max_value + (float)$report->result),2);
            if($value < 0 && $value > $this->sensor->max_value) {
                if ($value >= $this->average) {
                    $dynamic = null;
                    $static = $value;
                } else {
                    $dynamic = $value;
                    $static = null;
                }
                array_push($toInsert,[
                    'sensor_id' => $this->sensor->id,
                    'dynamic_level' => $dynamic,
                    'static_level' => $static,
                    'current_average' => $this->average,
                    'date' => $report->date
                ]);
            }

        }

        SensorBehavior::insert($toInsert);

    }

    protected function checkPointer($report)
    {
        if(Carbon::parse($this->pointer)->diffInSeconds(Carbon::parse($report->date)) > (60*60*6)) {

            $this->setAveragePointerDate($report->date);
            $this->average = $this->calculateLastAverage($report);
            $this->setLastAverage($this->average);
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

    protected function getPointerDate()
    {
        $average = $this->sensor->average;
        $this->average = $average->last_average;
        if ($average->pointer_date != null) {
            return $average->pointer_date;
        } else {
            $pointer =  $this->sensor->analogous_reports()->first()->date;
            $this->setAveragePointerDate($pointer);
            return $pointer;
        }
    }

    protected function setAveragePointerDate($pointer)
    {
        $this->sensor->average()->update(['pointer_date' => $pointer]);
    }

    protected function setLastAverage($average)
    {
        $this->sensor->average()->update(['last_average' => $average]);
    }

}
