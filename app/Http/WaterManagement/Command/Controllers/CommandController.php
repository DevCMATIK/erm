<?php

namespace App\Http\WaterManagement\Command\Controllers;

use App\App\Traits\Request\HasIPTrait;
use App\Domain\WaterManagement\Device\Address\Address;
use App\Domain\WaterManagement\Device\Device;
use App\Domain\WaterManagement\Device\Sensor\Sensor;
use App\Domain\WaterManagement\Log\CommandLog;
use App\Domain\WaterManagement\Main\Command;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;
use Sentinel;

class CommandController extends Controller
{
    use HasIPTrait;

    public function sendCommand(Request $request)
    {
        $element = explode('_',$request->element);
        $grd_id = $element[1];
        $address = $element[5];
        Command::create([
           'command_id' => null,
           'function' => 0,
           'grd_id' => $grd_id,
           'register_type' => 9,
           'output_number' => $address,
           'state' => $request->order,
           'date' => Carbon::now()->toDateTimeString()
        ]);

        $this->insertCommandLog($grd_id,$address,$request->order);
    }

    protected function insertCommandLog($grd_id,$address,$order)
    {
        $device = Device::where('internal_id',$grd_id)->first();
        $add = Address::where('register_type_id',9)->first();
        $sensor = Sensor::where('address_id',$add->id)->where('address_number',$address)
                            ->where('device_id',$device->id)->first();
        CommandLog::create([
            'user_id' => Sentinel::getUser()->id,
            'device_id' => $device->id,
            'sensor_id' => $sensor->id,
            'grd_id' => $grd_id,
            'address' => $address,
            'order_executed' => $order,
            'execution_date' => Carbon::now()->toDateTimeString(),
            'ip_address' => request()->ip()
        ]);
    }

}
