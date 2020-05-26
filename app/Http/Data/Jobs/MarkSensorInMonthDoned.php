<?php

namespace App\Http\Data\Jobs;

use App\Domain\Data\Device\DeviceDataCheck;
use App\Domain\WaterManagement\Device\Device;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class MarkSensorInMonthDoned implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $device;

    public $month;

    public $address;


    public function __construct(Device $device,$month,$address)
    {
        $this->device = $device;
        $this->month = $month;
        $this->address = $address;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        DeviceDataCheck::where('device_id',$this->device->id)
           ->where('address',$this->address)
           ->where('month',$this->month)
           ->first()->update([
               'check' => 1
           ]);
    }
}
