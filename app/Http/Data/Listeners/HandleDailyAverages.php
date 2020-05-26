<?php

namespace App\Http\Data\Listeners;

use App\Domain\WaterManagement\Device\Sensor\Behavior\SensorBehavior;
use App\Http\Data\Events\BackupedAverages;
use App\Http\Data\Jobs\BackupDailyAverages;
use Carbon\Carbon;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class HandleDailyAverages implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }


    public function handle(BackupedAverages $event)
    {
        $months =  SensorBehavior::where('sensor_id',$event->sensor_id)->orderBy('date')->get()
            ->groupBy(function ($val) {
                return Carbon::parse($val->date)->format('m');
            });
        foreach($months as $month){

            BackupDailyAverages::dispatch($month,$event->sensor_id);

        }
    }
}
