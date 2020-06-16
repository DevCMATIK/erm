<?php

namespace App\Http\WaterManagement\Admin\Device\Controllers;

use App\Domain\WaterManagement\Device\Sensor\Disposition\SensorDisposition;
use App\Domain\WaterManagement\Device\Sensor\Sensor;
use App\Domain\WaterManagement\Scale\Scale;
use App\Domain\WaterManagement\Unit\Unit;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;

class AdminDeviceScaleFormController extends Controller
{
    public function index($sensor_id)
    {
        $sensor = Sensor::with(['type','address','dispositions','average'])->find($sensor_id);
        $units = Unit::get();
        $scales = Scale::get();
        return view('water-management.admin.device.scale-form',compact('sensor','units','scales'));
    }

    public function newScale($row)
    {
        $units = Unit::get();
        $scales = Scale::get();

        return view('water-management.admin.device.new-scale',compact('units','scales','row'));
    }

    public function store(Request $request,$sensor_id)
    {
        $sensor  = Sensor::with('dispositions')->findOrFail($sensor_id);
        $scales = Scale::get();
        $units = Unit::get();
        if ($sensor->update([
            'enabled' => ($request->has('enabled'))?1:0,
            'has_alarm' => ($request->has('has_alarm'))?1:0,
            'historial' => ($request->has('historial'))?1:0,
            'fix_values_out_of_range' => ($request->has('fix_values_out_of_range'))?1:0,
            'fix_values' => ($request->has('fix_values'))?1:0,
            'fix_min_value' =>  ($request->has('fix_values'))?$request->fix_min_value:null,
            'fix_max_value' =>  ($request->has('fix_values'))?$request->fix_max_value:null
        ]) ) {
            $sensor->dispositions()->delete();

            for ($i = 0; $i < count($request->name) ; $i++) {
                $this->addDisposition($request,$i,$sensor,$scales,$units);
            }
            return $this->getResponse('success.store');

        } else {
            return $this->getResponse('error.store');
        }
    }

    protected function addDisposition(Request $request,$i,$sensor,$scales,$units)
    {

        $scale = $scales->where('id',$request->scale_id[$i])->first();
        $unit = $units->where('id',$request->unit_id[$i])->first();
        if($request->name[$i] !=  ''  && $request->sensor_min[$i] != '' && $request->sensor_max[$i] != '') {
           $dis =  $sensor->dispositions()->create([
                'name' => $request->name[$i],
                'scale_id' => $scale->id,
                'unit_id' => $unit->id,
                'scale_min' => ($scale->min != '') ? (float)$scale->min : $request->scale_min[$i],
                'scale_max' => ($scale->max != '') ? (float)$scale->max : $request->scale_max[$i],
                'sensor_min' => (float)$request->sensor_min[$i],
                'sensor_max' =>  (float)$request->sensor_max[$i],
                'precision' => ($request->precision[$i]) ?? 0,
            ]);

        }


    }

    public function deleteDisposition($id)
    {
        SensorDisposition::destroy($id);
    }
}
