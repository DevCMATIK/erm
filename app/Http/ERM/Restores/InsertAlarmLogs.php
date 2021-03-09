<?php

namespace App\Http\ERM\Restores;

use App\Domain\WaterManagement\Device\Sensor\Alarm\SensorAlarm;
use App\Domain\WaterManagement\Device\Sensor\Alarm\SensorAlarmLog;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class InsertAlarmLogs implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $records;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($records)
    {
        //
        $this->records = $records;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        SensorAlarmLog::insert($this->records);
    }
}
