<?php

namespace App\Http\Data\Listeners;

use App\Http\Data\Events\BackupDevice;
use App\Http\Data\Events\BackupDeviceByMonth;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class BackupDeviceStarted
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

    /**
     * Handle the event.
     *
     * @param  BackupDevice $event
     * @return void
     */
    public function handle(BackupDevice $event)
    {
        $device = $event->device;
        $data = $device->data_checks->pluck('month');

        foreach($data as $month => $values) {
            event(new BackupDeviceByMonth($device,$month));
        }
    }
}
