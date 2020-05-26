<?php

namespace App\Http\WaterManagement\Dashboard\Electricity;

use App\Domain\WaterManagement\Device\Sensor\Sensor;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;

class TensionValuesController extends Controller
{
    public function __invoke(Request $request)
    {
        $sensors = Sensor::with([
            'type',
            'dispositions.unit',
            'selected_disposition.unit',
            'device.report'
        ])->whereIn('id',explode(',',$request->sensors))->get()->groupBy('type.slug');

        $class = 'bg-primary-300';
        $function = 'avg';
        return view('water-management.dashboard.views.electric.values',compact('sensors','class','function'));
    }
}
