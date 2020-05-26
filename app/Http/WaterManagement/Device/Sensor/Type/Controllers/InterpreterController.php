<?php

namespace App\Http\WaterManagement\Device\Sensor\Type\Controllers;

use App\Domain\WaterManagement\Device\Sensor\Sensor;
use App\Domain\WaterManagement\Device\Sensor\Type\Interpreter;
use App\Domain\WaterManagement\Device\Sensor\Type\SensorType;
use Illuminate\Http\Request;
use App\app\Controllers\Controller;

class InterpreterController extends Controller
{
    public function index(Request $request)
    {

        $type = SensorType::find($request->type_id);
        return view('water-management.device.sensor.type.interpreter.index',[
            'type_id' => $request->type_id,
            'type' => $type
        ]);
    }

    public function create(Request $request)
    {
        $type = SensorType::find($request->type_id);
        $type_id = $request->type_id;
        return view('water-management.device.sensor.type.interpreter.create',compact('type','type_id'));
    }

    public function store(Request $request)
    {
        if ( Interpreter::create($request->all()))
        {
            return $this->getResponse('success.store');
        } else {
            return $this->getResponse('error.store');
        }
    }

    public function edit($id)
    {
        $interpreter = Interpreter::findOrFail($id);
        return view('water-management.device.sensor.type.interpreter.edit',compact('interpreter'));
    }

    public function update(Request $request,$id)
    {
        $interpreter = Interpreter::findOrFail($id);

        if ($interpreter->update($request->all())) {
            return $this->getResponse('success.update');
        } else {
            return $this->getResponse('error,update');
        }
    }

    public function destroy($id)
    {
        $interpreter = Sensor::findOrFail($id);
        if ($interpreter->delete()) {
            return $this->getResponse('success.destroy');
        } else {
            return $this->getResponse('error.destroy');
        }
    }
}
