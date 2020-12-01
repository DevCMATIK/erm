<?php

namespace App\Http\WaterManagement\Dashboard\Energy\Controllers\Data;

use App\App\Traits\ERM\HasAnalogousData;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;

class VarDataController extends Controller
{
    use HasAnalogousData;

    public function __invoke(Request $request)
    {
        $sensors = $this->getSensorsData($request);
        $sensor = $sensors->first();

        if($request->func === 'sum') {
            $value = number_format($sensors->sum('value'),$sensor['disposition']->precision,',','');
        } else {
            $value = number_format($sensors->avg('value'),$sensor['disposition']->precision,',','');
        }

        return view('water-management.dashboard.energy.components.data-box',[
            'bg' => $request->bg,
            'value' => $value,
            'unit' => $sensor['unit'],
            'title' => ($request->name == 'ee-e-corriente')?'Energía '.$sensor['name']:$sensor['name'],
            'mb' => $request->mb
        ]);
    }

    protected function getSensorsData(Request $request)
    {
        $sensors = array();
        if($request->has('sensor_name') && $request->sensor_name != null) {
            $rows = $this->getSensorsBySubZoneAndName($request->sub_zone,$request->name,$request->sensor_name);
        } else {
            $rows = $this->getSensorsBySubZoneAndType($request->sub_zone,$request->name);
        }
        foreach ($rows as $sensor) {
            array_push($sensors,$this->getAnalogousValue($sensor));
        }
        return collect($sensors);
    }
}
