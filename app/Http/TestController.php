<?php

namespace App\Http;

use App\App\Controllers\Controller;
use App\Domain\WaterManagement\Device\Sensor\Chronometer\ChronometerTracking;
use App\Domain\WaterManagement\Device\Sensor\Electric\ElectricityConsumption;
use App\Domain\WaterManagement\Device\Sensor\Sensor;
use Carbon\Carbon;
use Illuminate\Http\Request;


class TestController extends Controller
{


    public function __invoke(Request $request)
    {
        $trackings = ChronometerTracking::whereNotNull('end_date')->whereNull('diff_in_seconds')->get();
        foreach($trackings as $tracking) {
            $tracking->diff_in_seconds = Carbon::parse($tracking->end_date)->diffInSeconds(Carbon::parse($tracking->start_date));
            $tracking->diff_in_minutes = Carbon::parse($tracking->end_date)->diffInMinutes(Carbon::parse($tracking->start_date));
            $tracking->diff_in_hours = Carbon::parse($tracking->end_date)->diffInHours(Carbon::parse($tracking->start_date));
            $tracking->save();
        }
    }

    protected function getSensors($date)
    {
        $first_date = Carbon::parse($date)->toDateString();
        $second_date = Carbon::parse($date)->addDay()->toDateString();
        return  Sensor::whereHas('type', $typeFilter = function ($q) {
            return $q->where('slug','ee-e-activa')->orWhere('slug','ee-e-reactiva')->orWhere('slug','ee-e-aparente');
        })->whereHas('analogous_reports', $reportsFilter = function($query) use ($first_date,$second_date){
            return $query->whereRaw("analogous_reports.date between '{$first_date} 00:00:00' and '{$second_date} 00:01:00'");
        })->with([
            'type' => $typeFilter,
            'device.check_point.sub_zones',
            'analogous_reports' => $reportsFilter,
            'consumptions'
        ])->get();
    }
}
