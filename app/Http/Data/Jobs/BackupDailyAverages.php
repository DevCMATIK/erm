<?php

namespace App\Http\Data\Jobs;

use App\Domain\WaterManagement\Device\Sensor\Behavior\SensorBehavior;
use App\Domain\WaterManagement\Device\Sensor\Behavior\SensorDailyAverage;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class BackupDailyAverages implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $month;
    public $sensor_id;

    public function __construct($month,$sensor_id)
    {
        $this->month = $month;
        $this->sensor_id = $sensor_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $days =  $this->month->groupBy(function ($val) {
            return Carbon::parse($val->date)->format('d');
        });
        $toInsert = array();
        foreach($days as $day) {
            $staticAvg = $day->filter(function($item){
                return $item->static_level != null;
            })->avg('static_level');
            $dynamicAvg = $day->filter(function($item){
                return $item->dynamic_level != null;
            })->avg('dynamic_level');
            $average = number_format(((($dynamicAvg - $staticAvg)/2) -($dynamicAvg)),3)*-1;

            if($average == 0 || $average == null) {
                if($row = SensorDailyAverage::where('sensor_id',$this->sensor_id)->orderBy('id','DESC')->first()){
                    $average = $row->current_average;
                } else {
                    $row = SensorBehavior::where('sensor_id',$this->sensor_id)->first();
                    $average = $row->current_average;
                }

            }

            array_push($toInsert,[
                'sensor_id' => $this->sensor_id,
                'static_level' => $staticAvg,
                'dynamic_level' => $dynamicAvg,
                'current_average' => $average,
                'date' => $day->first()->date,
            ]);
        }


        SensorDailyAverage::insert($toInsert);
    }
}
