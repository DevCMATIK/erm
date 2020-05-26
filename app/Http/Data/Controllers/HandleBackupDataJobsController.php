<?php

namespace App\Http\Data\Controllers;

use App\Domain\WaterManagement\Device\Device;
use App\Domain\WaterManagement\Device\Sensor\Sensor;
use App\Http\Data\Events\BackupDevice;
use App\Http\Data\Events\BackupDeviceByMonth;
use App\Http\Data\Events\BackupDeviceBySensor;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;

class HandleBackupDataJobsController extends Controller
{
    public function backupDevice($device_id)
    {
        $device = Device::with([
            'sensors.address',
            'sensors.label',
            'sensors.dispositions.scale',
            'sensors.dispositions.unit'
        ])->find($device_id);

        event(new BackupDevice($device));

        return back()->with('success','Se ha creado el proceso de respaldo del dispositivo: '.$device->name);
    }

    public function backupDeviceByMonth($month,$device_id)
    {
        $device = Device::with([
            'sensors.address',
            'sensors.label',
            'sensors.dispositions.scale',
            'sensors.dispositions.unit'
        ])->find($device_id);

        event(new BackupDeviceByMonth($device, $month));

        return back()->with('success','Se ha creado el proceso de respaldo del dispositivo: '.$device->name.' en el mes: '.$month);
    }

    public function backupDeviceBySensor($month,$device_id,$address)
    {

        $device = Device::find($device_id);
        $sensor = collect($device->sensors->toArray())->where('full_address',$address)->first();
        $sensor = Sensor::with([
            'address',
            'label',
            'dispositions.scale',
            'dispositions.unit'
        ])->find($sensor['id']);


        event(new BackupDeviceBySensor($device, $month, $sensor));


        return back()->with('success','Se ha creado el proceso de respaldo del sensor: '.$address.' del dispositivo: '. $device->name.' en el mes: '.$month);
    }


}
