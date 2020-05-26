<?php

namespace App\Http\Data\Jobs\Average;

use App\Domain\WaterManagement\Device\Sensor\Behavior\SensorBehavior;
use App\Domain\WaterManagement\Device\Sensor\Behavior\SensorDailyAverage;
use App\Domain\WaterManagement\Device\Sensor\Sensor;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class BackupDailySensorAverages implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
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
        $sensors  = $this->getSensors();
        $toInsert = array();
        foreach ($sensors as $sensor) {
            $staticAvg = $sensor->behaviors->filter(function($item){
                return $item->static_level != null;
            })->avg('static_level');
            $dynamicAvg = $sensor->behaviors->filter(function($item){
                return $item->dynamic_level != null;
            })->avg('dynamic_level');
            $average = number_format(((($dynamicAvg - $staticAvg)/2) -($dynamicAvg)),3)*-1;

            if($average == 0 || $average == null) {
                if($row = SensorDailyAverage::where('sensor_id',$sensor->id)->orderBy('id','DESC')->first()){
                    $average = $row->current_average;
                } else {
                    $row = SensorBehavior::where('sensor_id',$sensor->id)->first();
                    $average = $row->current_average;
                }

            }

            array_push($toInsert,[
                'sensor_id' => $sensor->id,
                'static_level' => $staticAvg,
                'dynamic_level' => $dynamicAvg,
                'current_average' => $average,
                'date' => Carbon::yesterday()->toDateTimeString(),
            ]);
        }

        SensorDailyAverage::insert($toInsert);
    }

    protected function getSensors()
    {
        return Sensor::with([
            'average',
            'behaviors' => function($q){
                return $q->date('date',Carbon::yesterday()->toDateString());
            }
        ])->has('average')->get();
    }
}
