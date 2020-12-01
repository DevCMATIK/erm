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
        $sensors = $this->getSensorsData($request->sub_zone,$request->name);
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
            'title' => $sensor['name'],
            'mb' => $request->mb
        ]);
    }

    protected function getSensorsData($sub_zone,$name)
    {
        $sensors = array();
        foreach ($this->getSensorsBySubZoneAndType($sub_zone,$name) as $sensor) {
            array_push($sensors,$this->getAnalogousValue($sensor));
        }
        return collect($sensors);
    }
}
