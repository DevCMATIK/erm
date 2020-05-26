<?php

namespace App\Http\WaterManagement\Admin\Panel;

use App\Domain\WaterManagement\Device\Sensor\Disposition\SensorDisposition;
use App\Domain\WaterManagement\Device\Sensor\Range\SensorRange;
use App\Domain\WaterManagement\Device\Sensor\Sensor;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;

class SensorRangesController extends Controller
{
    public function index($sensor_id)
    {
        $sensor = Sensor::with(['ranges','dispositions'])->find($sensor_id);
        $this->checkRanges($sensor);
        return view('water-management.admin.panel.sensor-ranges',compact('sensor'));
    }

    public function store(Request $request, $sensor)
    {

        for($i = 0; $i < count($request->color);$i++) {
            SensorRange::where('sensor_id',$sensor)->where('color',$request->color[$i])->first()->update([
               'min' => $request->min[$i] ?? null,
               'max' => $request->max[$i] ?? null
            ]);
        }
        $disposition = SensorDisposition::with('unit')->find($request->default_disposition);

        Sensor::find($sensor)->update([
            'max_value' => ($disposition->unit->name == '%')?100:$request->max_value,
            'default_disposition' => $request->default_disposition
        ]);
        return $this->getResponse('success.store');
    }
    protected function checkRanges($sensor)
    {
        if(count($sensor->ranges) == 0) {
            $sensor->ranges()->create([
                'color' => 'danger'
            ]);
            $sensor->ranges()->create([
                'color' => 'warning'
            ]);
            $sensor->ranges()->create([
                'color' => 'success'
            ]);
        }
    }
}
