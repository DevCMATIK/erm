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
        foreach($this->getSensorsBySubZoneAndType($request->sub_zone,$request->name) as $sensor) {
            dd($this->getAnalogousValue($sensor));
        }
        return view('water-management.dashboard.energy.components.data-box',[
            'bg' => 'bg-success-300',
            'value' => 0,
            'measure' => 'KWH',
            'title' => 'TITULO',
        ]);
    }
}
