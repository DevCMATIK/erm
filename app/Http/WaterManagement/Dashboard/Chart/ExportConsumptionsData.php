<?php

namespace App\Http\WaterManagement\Dashboard\Chart;

use App\Domain\Client\Zone\Sub\SubZone;
use App\Domain\WaterManagement\Device\Sensor\Sensor;
use App\Exports\ExportConsumptions;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;

class ExportConsumptionsData extends Controller
{
    public function __invoke(Request $request,$sub_zone_id)
    {
       $sub_zone = SubZone::with('zone')->find($sub_zone_id);
        $fileName = $sub_zone->zone->name.'-'.$sub_zone->name.'-Consumos.xlsx';
        if(strlen($fileName) > 31) {
            $fileName = substr($sub_zone->zone->name.'-'.$sub_zone->name,'0','20').'-Consumos.xlsx';
        }
        return (new ExportConsumptions($request,$sub_zone))
            ->download($fileName);
    }
}
