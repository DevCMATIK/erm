<?php

namespace App\App\Providers;

use App\Http\Auth\Events\UserFortgotsPassword;
use App\Http\Auth\Events\UserRegistered;
use App\Http\Auth\Listeners\SendMailAccountCreated;
use App\Http\Auth\Listeners\SendMailPasswordRecovery;
use App\Http\Data\Events\BackupDevice;
use App\Http\Data\Events\BackupDeviceByMonth;
use App\Http\Data\Events\BackupDeviceBySensor;
use App\Http\Data\Events\BackupedAverages;
use App\Http\Data\Events\BackupSensorAverages;
use App\Http\Data\Listeners\BackupDeviceByMonthStarted;
use App\Http\Data\Listeners\BackupDeviceBySensorStarted;
use App\Http\Data\Listeners\BackupDeviceStarted;
use App\Http\Data\Listeners\BackupSensorAveragesStarted;
use App\Http\Data\Listeners\HandleDailyAverages;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        UserRegistered::class => [
            SendMailAccountCreated::class,
        ],
        UserFortgotsPassword::class => [
            SendMailPasswordRecovery::class
        ],
        BackupDevice::class => [
            BackupDeviceStarted::class
        ],
        BackupDeviceByMonth::class => [
            BackupDeviceByMonthStarted::class
        ],
        BackupDeviceBySensor::class => [
            BackupDeviceBySensorStarted::class
        ],
        BackupSensorAverages::class => [
            BackupSensorAveragesStarted::class
        ],
        BackupedAverages::class => [
            HandleDailyAverages::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
