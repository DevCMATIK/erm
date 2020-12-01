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
        $sensors = collect($this->getSensorsBySubZoneAndType($request->sub_zone,$request->name));
        $sensor_data = $sensors->first();

        dd($sensor_data,$sensor_data['disposition']);
        if($request->func === 'sum') {
            $value = number_format($sensors->sum('value'),$sensor_data['disposition']->precision,',','');
        } else {
            $value = number_format($sensors->avg('value'),$sensor_data['disposition'],',','');
        }

        return view('water-management.dashboard.energy.components.data-box',[
            'bg' => $request->bg,
            'value' => $value,
            'measure' => $sensor_data['unit'],
            'title' => $sensor_data['name'],
            'mb' => $request->mb
        ]);
    }
}
