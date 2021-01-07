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
use App\Http\Data\Jobs\Device\TrackDisconnections;
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

        $schedule->job(new ExecuteCommandTriggered(1))->everyMinute();
        $schedule->job(new ExecuteCommandTriggered(5))->everyFiveMinutes();
        $schedule->job(new ExecuteCommandTriggered(10))->everyTenMinutes();
        $schedule->job(new CheckAlarms())->everyMinute();

        $schedule->job(new BackupAnalogousSensors(1),'long-running-queue')->everyMinute();
        $schedule->job(new BackupAnalogousSensors(5),'long-running-queue')->everyFiveMinutes();
        $schedule->job(new BackupAnalogousSensors(10),'long-running-queue')->everyTenMinutes();
        $schedule->job(new BackupAnalogousSensors(15),'long-running-queue')->everyFifteenMinutes();
        $schedule->job(new BackupAnalogousSensors(30),'long-running-queue')->everyThirtyMinutes();
        $schedule->job(new BackupAnalogousSensors(60),'long-running-queue')->hourly();
        $schedule->job(new BackupDigitalSensors(),'long-running-queue')->everyFiveMinutes();
        $schedule->job(new BackupSensorAverages(),'long-running-queue-low')->everyFiveMinutes();
        $schedule->job(new BackupDailySensorAverages(),'long-running-queue-low')->dailyAt('04:00');
        $schedule->job(new BackupAverageFlow(),'long-running-queue-low')->dailyAt('03:00');
        //DGA REPORT
        $schedule->job(new ReportToDGA(1),'long-running-queue-low')->hourly();
        //Diario
        $schedule->job(new ReportToDGA(2),'long-running-queue-low')->dailyAt('00:04');
        // mensual
        $schedule->job(new ReportToDGA(3),'long-running-queue-low')->monthlyOn(1,'00:01');
        //anual
        $schedule->job(new ReportToDGA(4),'long-running-queue-low')->yearly();
        $schedule->job(new BackupTotalizers(),'long-running-queue-low')->dailyAt('02:00');
        $schedule->job(new BackupEnergy('ee-e-activa'),'long-running-queue-low')->dailyAt('01:20');
        $schedule->job(new BackupEnergy('ee-e-reactiva'),'long-running-queue-low')->dailyAt('01:30');
        $schedule->job(new BackupEnergy('ee-e-aparente'),'long-running-queue-low')->dailyAt('01:40');
        $schedule->job(new BackupWater())->dailyAt('02:20');
        $schedule->job(new CalculateConsumptions(),'long-running-queue-low')->hourlyAt(52);
        $schedule->job(new SendReminderMail())->everyThirtyMinutes();
        $schedule->job(new NotifyDevicesOffline())->hourly();
        $schedule->job(new TrackDisconnections(),'tracking-queue')->everyMinute();

        // Get all tasks from the database
        $mailReports = MailReport::active()->get();
        // Go through each task to dynamically set them up.
        foreach ($mailReports as $task) {
            // Use the scheduler to add the task at its desired frequency
            $schedule->call(function() use ($task) {
                   SendReportMail::dispatch($task->id);
            })->cron($task->generateCron());
        }

        //chronometers
        $seconds = 10;

        $schedule->call(function () use ($seconds) {

            $dt = Carbon::now();

            $x=60/$seconds;

            do{

                TrackSensors::dispatch()->onQueue('tracking-queue');
                //app(InputReadingController::class)->handle();
                time_sleep_until($dt->addSeconds($seconds)->timestamp);

            } while($x-- > 0);

        })->everyMinute();
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
