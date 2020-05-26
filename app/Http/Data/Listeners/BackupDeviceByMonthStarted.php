<?php

namespace App\Http\Data\Listeners;

use App\Domain\WaterManagement\Device\Sensor\Sensor;
use App\Http\Data\Events\BackupDeviceByMonth;
use App\Http\Data\Events\BackupDeviceBySensor;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class BackupDeviceByMonthStarted
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


    public function handle(BackupDeviceByMonth $event)
    {
        $device = $event->device;
        $monthSelected = $event->month;
        $monthData = $device->data_checks()->where('month',$monthSelected)->get();
        foreach($monthData as $data) {
            $ss = collect($device->sensors->toArray())->where('full_address',$data->address)->first();
            $sensor = Sensor::with([
                'address',
                'label',
                'dispositions.scale',
                'dispositions.unit'
            ])->find($ss['id']);
            event(new BackupDeviceBySensor($device,$monthSelected,$sensor));
        }

    }
}
