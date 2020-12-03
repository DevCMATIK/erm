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
            $value = number_format($sensors->sum('value'),$sensor['disposition']->precision ?? 1,',','');
        } else {
            $value = number_format($sensors->avg('value'),$sensor['disposition']->precision ?? 1,',','');
        }

        return view('water-management.dashboard.energy.components.data-box',[
            'bg' => $request->bg,
            'value' => $value,
            'unit' => $sensor['unit'] ?? $request->opt_unit ?? '?',
            'title' => (collect(['ee-e-activa','ee-e-reactiva','ee-e-aparente'])->contains($request->name))?'Energía '.$sensor['name'] ?? $request->sensor_opt ?? 'Desconectado':$sensor['name'] ?? $request->sensor_opt ?? 'Desconectado',
            'mb' => $request->mb,
            'name' => $request->name,
            'sensor_name' => $request->sensor_name
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
