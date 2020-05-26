<?php

namespace App\Http\WaterManagement\Admin\Device\Controllers;

use App\Domain\WaterManagement\Device\Sensor\Sensor;
use App\App\Controllers\Controller;
use Illuminate\Http\Request;

class AdminDeviceBooleanFormController extends Controller
{
    public function index($sensor_id)
    {
        $sensor = Sensor::with(['type','address','label'])->find($sensor_id);
        return view('water-management.admin.device.boolean-form',compact('sensor'));
    }

    public function store(Request $request,$id)
    {
        $sensor  = Sensor::with('label')->findOrFail($id);
        if ($sensor->update([
            'enabled' => ($request->has('enabled'))?1:0,
            'has_alarm' => ($request->has('has_alarm'))?1:0,
            'historial' => ($request->has('historial'))?1:0
        ]) ) {
            if (!isset($sensor->label)) {
                $sensor->label()->create([
                    'name' => $request->name,
                    'on_label' => $request->on_label,
                    'off_label' => $request->off_label
                ]);
            } else {
                $sensor->label->update([
                    'name' => $request->name,
                    'on_label' => $request->on_label,
                    'off_label' => $request->off_label
                ]);
            }
            return $this->getResponse('success.store');
        } else {
            return $this->getResponse('error.store');
        }
    }
}
