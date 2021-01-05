<?php

namespace App\App\Console;


use App\App\Jobs\TrackSensors;
use App\Domain\WaterManagement\Report\MailReport;
use App\Http\Data\Electric\BackupEnergy;
use App\Http\Data\Jobs\Average\BackupDailySensorAverages;
use App\Http\Data\Jobs\Average\BackupSensorAverages;
use App\Http\Data\Jobs\CheckPoint\BackupAverageFlow;
use App\Http\Data\Jobs\CheckPoint\BackupTotalizers;
use App\Http\Data\Jobs\CheckPOint\CalculateConsumptions;
use App\Http\Data\Jobs\CheckPoint\ReportToDGA;
use App\Http\Data\Jobs\Device\NotifyDevicesOffline;
use App\Http\Data\Jobs\Device\TrackDeviceDisconnections;
use App\Http\Data\Jobs\ProcessData;
use App\Http\Data\Jobs\Sensors\BackupAnalogousSensors;
use App\Http\Data\Jobs\Sensors\BackupDigitalSensors;
use App\Http\Data\Water\BackupWater;
use App\Http\WaterManagement\Device\Sensor\Alarm\Jobs\CheckAlarms;
use App\Http\WaterManagement\Device\Sensor\Alarm\Jobs\SendReminderMail;
use App\Http\WaterManagement\Device\Sensor\Trigger\Jobs\ExecuteCommandTriggered;
use App\Http\WaterManagement\Report\Jobs\SendReportMail;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

       
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
