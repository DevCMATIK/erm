<?php

namespace App\Http\WaterManagement\Device\Sensor\Alarm\Jobs;

use App\Domain\WaterManagement\Device\Sensor\Alarm\SensorAlarm;
use App\Http\WaterManagement\Device\Sensor\Alarm\Traits\AlarmRemindersTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendReminderMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels,AlarmRemindersTrait;

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
            'notifications.mail.attachables',
            'notifications.reminder',
            'sensor.address',
            'sensor.dispositions'
        ])->has('active_and_accused_alarm')->where('is_active',1)->get();

        $this->handleAlarms($alarms);
    }
}
