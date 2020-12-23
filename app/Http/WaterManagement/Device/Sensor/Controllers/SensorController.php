<?php

namespace App\Http\WaterManagement\Device\Sensor\Controllers;

use App\App\Controllers\Controller;
use App\App\Traits\Views\HasNavBarTrait;
use App\Domain\Client\CheckPoint\Type\CheckPointType;
use App\Domain\WaterManagement\Device\Address\Address;
use App\Domain\WaterManagement\Device\Device;
use App\Domain\WaterManagement\Device\Sensor\Sensor;
use App\Domain\WaterManagement\Device\Sensor\Type\SensorType;
use App\Http\WaterManagement\Device\Sensor\Requests\SensorRequest;
use Illuminate\Http\Request;

class SensorController extends Controller
{
    use HasNavBarTrait;

    public function index(Request $request)
    {
        $checkPointTypes = CheckPointType::with([
            'check_points.devices.sensors'
        ])->get();
        $navBar = $this->makeNavBar($checkPointTypes,[
            'check_point_types' => [
                'url' => '/check-points?type=',
                'field' => 'slug',
                'name' => 'name',
                'alter' => 'Ver Check Points'
            ],
            'check_points' => [
                'url' => '/devices?check_point_id=',
                'field' => 'id',
                'name' => 'name',
                'alter' => 'Ver Dispositivos'
            ],
            'devices' => [
                'url' => '/sensors?device_id=',
                'field' => 'id',
                'name' => 'name',
                'alter' => 'Ver Sensores'
            ],
            'sensors' => [
                'name' => 'full_address'
            ]
        ]);
        $device = Device::find($request->device_id);
        return view('water-management.device.sensor.index',[
            'device_id' => $request->device_id,
            'device' => $device,
            'navBar' => $navBar
        ]);
    }

    public function create(Request $request)
    {
        $types = SensorType::get();
        $addresses = Address::get();
        $device_id = $request->device_id;
        $device = Device::find($device_id);
        return view('water-management.device.sensor.create',compact('types','addresses', 'device_id','device'));
    }

    public function store(SensorRequest $request)
    {
        if ($record = Sensor::create($request->all()))
        {
                if($record->address->configuration_type == 'scale') {
                    $record->ranges()->create([
                        'color' => 'danger'
                    ]);
                    $record->ranges()->create([
                        'color' => 'warning'
                    ]);
                    $record->ranges()->create([
                        'color' => 'success'
                    ]);
                }
            return $this->getResponse('success.store');
        } else {
            return $this->getResponse('error.store');
        }
    }

    public function edit($id)
    {
        $types = SensorType::get();
        $addresses = Address::get();
        $sensor = Sensor::findOrFail($id);
        return view('water-management.device.sensor.edit',compact('types','addresses','sensor'));
    }

    public function update(SensorRequest $request,$id)
    {
        $record = Sensor::findOrFail($id);
        if ($record->update($request->all())) {
            return $this->getResponse('success.update');
        } else {
            return $this->getResponse('error,update');
        }
    }

    public function destroy($id)
    {
        $record = Sensor::findOrFail($id);
        $record->dispositions()->delete();
        $record->label()->delete();
        $record->ranges()->delete();
        $record->analogous_reports()->delete();
        $record->digital_reports()->delete();
        $record->triggers()->delete();
        $record->alarms()->delete();
        $record->mail_reports()->detach();
        $record->average()->delete();
        $record->behaviors()->delete();
        $record->daily_averages()->delete();
        if ($record->delete()) {
            return $this->getResponse('success.destroy');
        } else {
            return $this->getResponse('error.destroy');
        }
    }
}
