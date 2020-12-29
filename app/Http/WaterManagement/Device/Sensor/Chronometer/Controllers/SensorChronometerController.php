<?php

namespace App\Http\WaterManagement\Device\Sensor\Chronometer\Controllers;

use App\App\Controllers\Controller;
use App\Domain\WaterManagement\Device\Sensor\Chronometer\SensorChronometer;
use App\Domain\WaterManagement\Device\Sensor\Sensor;
use Illuminate\Http\Request;

class SensorChronometerController extends Controller
{
    public function index(Request $request)
    {
        $sensor = Sensor::findOrFail($request->sensor_id);
        return view('water-management.device.sensor.chronometer.index',compact('sensor'));
    }

    public function create(Request $request)
    {
        $sensor = Sensor::findOrFail($request->sensor_id);
        return view('water-management.device.sensor.chronometer.create',compact('sensor'));
    }

    public function store(Request $request)
    {
        if (SensorChronometer::create([
            'sensor_id' => $request->sensor_id,
            'name' => $request->name,
            'equals_to' => $request->equals_to
        ])) {
            return $this->getResponse('success.store');
        } else {
            return $this->getResponse('error.store');
        }
    }

    public function edit($id)
    {
        $chronometer = SensorChronometer::findOrFail($id);
        return view('water-management.device.sensor.chronometer.edit',compact('chronometer'));
    }

    public function update(Request $request,$id)
    {
        $record = SensorChronometer::findOrFail($id);
            if ($record->update([
                'name' => $request->name,
                'equals_to' => $request->equals_to,
            ])) {
                return $this->getResponse('success.update');
            } else {
                return $this->getResponse('error.update');
            }

    }

    public function destroy($id)
    {
        $record = SensorChronometer::findOrFail($id);
        if ($record->delete()) {
            return $this->getResponse('success.destroy');
        } else {
            return $this->getResponse('error.destroy');
        }
    }
}
