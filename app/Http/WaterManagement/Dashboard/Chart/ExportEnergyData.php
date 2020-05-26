<?php

namespace App\Http\WaterManagement\Dashboard\Chart;

use App\Domain\WaterManagement\Device\Sensor\Sensor;
use App\Exports\ExportChartDataWithSheets;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;

class ExportEnergyData extends Controller
{
    public function __invoke(Request $request)
    {
        $ss = explode(',',$request->sensors);
        $sensors  = Sensor::with([
            'type',
            'device.check_point.sub_zones'
        ])->whereIn('id',$ss)->get();
        $fileName = $sensors->first()->device->check_point->sub_zones->first()->name.'-'.$request->name.'.xlsx';
        if(strlen($fileName) > 31) {
            $fileName = substr($sensors->first()->device->check_point->sub_zones->first()->name.'-'.$request->name,'0','20').'.xlsx';
        }
        return (new \App\Exports\ExportEnergyData($sensors,$request->dates))
            ->download($fileName);
    }
}
