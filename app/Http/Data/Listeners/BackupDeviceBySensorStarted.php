<?php

namespace App\Http\Data\Listeners;

use App\Domain\Data\Device\DeviceDataCheck;
use App\Domain\WaterManagement\Device\Sensor\Sensor;
use App\Domain\WaterManagement\Main\Historical;
use App\Http\Data\Events\BackupDeviceBySensor;
use App\Http\Data\Jobs\HandleAnalogousChunk;
use App\Http\Data\Jobs\HandleDigitalChunk;
use App\Http\Data\Jobs\MarkSensorInMonthDoned;
use Carbon\Carbon;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class BackupDeviceBySensorStarted
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

    public function handle(BackupDeviceBySensor $event)
    {

        $device = $event->device;
        $dataCheck = DeviceDataCheck::where('device_id',$device->id)
            ->where('address',$event->sensor->full_address)
            ->where('month',$event->month)
            ->first();
        if($dataCheck->check == 0) {
            $rows = Historical::where('grd_id', $device->internal_id)
                ->where('register_type',$event->sensor->address->register_type_id)
                ->where('address',$event->sensor->address_number)
                ->whereMonth('timestamp',$event->month)
                ->whereYear('timestamp',Carbon::today()->year)
                ->get()->toArray();
            $rows = collect($rows);
            if ($event->sensor->address->configuration_type == 'scale') {
                foreach ($rows->chunk(500) as $chunk) {
                    HandleAnalogousChunk::dispatch($device,$event->sensor,$event->month,$chunk);
                }
            } else {
                foreach ($rows->chunk(1000) as $chunk) {

                    HandleDigitalChunk::dispatch($device,$event->sensor,$event->month,$chunk);
                }
            }
            $dataCheck->update([
                'check' => 1
            ]);
        }

    }
}
