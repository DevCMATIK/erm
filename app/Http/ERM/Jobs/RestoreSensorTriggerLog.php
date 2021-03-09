<?php

namespace App\Http\ERM\Jobs;

use App\Domain\WaterManagement\Device\Sensor\Trigger\SensorTriggerLog;
use App\Http\ERM\Restores\InsertSensorTriggerLogs;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class RestoreSensorTriggerLog implements ShouldQueue
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
        $last_id = SensorTriggerLog::orderBy('id','desc')->first();

        \App\Domain\ERM\SensorTriggerLog::where('id','>',$last_id->id)->chunk(1000, function($records) {
            InsertSensorTriggerLogs::dispatch($records->toArray());
        });
    }
}
