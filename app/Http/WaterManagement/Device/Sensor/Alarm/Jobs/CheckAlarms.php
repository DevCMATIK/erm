<?php

namespace App\Http\WaterManagement\Device\Sensor\Alarm\Jobs;

use App\Domain\WaterManagement\Device\Sensor\Alarm\SensorAlarm;
use App\Http\WaterManagement\Device\Sensor\Alarm\Traits\CheckAlarmsTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CheckAlarms implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, CheckAlarmsTrait;

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
        $alarms = SensorAlarm::with([
            'last_log.user_reminders',
            'sensor.device.check_point.sub_zones.zone',
            'notifications.group.users',
            'notifications.mail.attachables',
            'notifications.reminder',
            'notifications',
            'sensor.address',
            'sensor.dispositions',
            'sensor.label'
        ])->where('is_active',1)->get();

        //$this->handleAlarms($alarms);
    }
}
