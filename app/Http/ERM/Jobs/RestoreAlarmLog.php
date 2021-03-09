<?php

namespace App\Http\ERM\Jobs;

use App\Domain\WaterManagement\Device\Sensor\Alarm\SensorAlarmLog;
use App\Http\ERM\Restores\InsertAlarmLogs;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class RestoreAlarmLog implements ShouldQueue
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
        $last_id = SensorAlarmLog::orderBy('id','desc')->first();

        \App\Domain\ERM\SensorAlarmLog::where('id','>',$last_id->id)->chunk(1000, function($records) {
            InsertAlarmLogs::dispatch($records->toArray());
        });
    }
}
