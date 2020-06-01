<?php

namespace App\Http;

use App\App\Controllers\Controller;
use App\Domain\WaterManagement\Device\Sensor\Electric\ElectricityConsumption;
use App\Domain\WaterManagement\Device\Sensor\Sensor;
use Carbon\Carbon;
use Illuminate\Http\Request;


class TestController extends Controller
{

    public function __invoke(Request $request)
    {
        $time_start = microtime(true);



        if($request->has('date')) {
            $sensors = $this->getSensors($request->date);

            foreach($sensors as $sensor) {
                if(count($sensor->consumptions) > 0) {
                    $first_read = $sensor->consumptions->sortByDesc('date')->first()->last_read;
                    $last_read = $sensor->analogous_reports->sortByDesc('date')->first()->result;
                } else {
                    $first_read = $sensor->analogous_reports->sortBy('date')->first()->result;
                    $last_read = $sensor->analogous_reports->sortByDesc('date')->first()->result;
                }
                dd($first_read,$last_read);
                if($first_read && $last_read) {
                    $consumption = $last_read - $first_read;
                    array_push($toInsert,[
                        'sensor_id' => $sensor->id,
                        'first_read' => $first_read,
                        'last_read' => $last_read,
                        'consumption' => $consumption,
                        'sensor_type' => $sensor->type->slug,
                        'sub_zone_id' => $sensor->device->check_point->sub_zones->first()->id,
                        'date' => Carbon::yesterday()->toDateString()
                    ]);
                }
            }

            ElectricityConsumption::insert($toInsert);
        }
        $time_end = microtime(true);

        $execution_time = ($time_end - $time_start);
        dd($execution_time);
    }

    protected function getSensors($date)
    {
        $first_date = Carbon::parse($date)->toDateString();
        $second_date = Carbon::parse($date)->addDay()->toDateString();
        return  Sensor::whereHas('type', $typeFilter = function ($q) {
            return $q->where('slug','ee-e-activa')->orWhere('slug','ee-e-reactiva')->orWhere('slug','ee-e-aparente');
        })->whereHas('analogous_reports', $reportsFilter = function($query) use ($first_date,$second_date){
            return $query->whereRaw("date between '{$first_date} 00:00:00' and '{$second_date} 00:01:00'");
        })->with([
            'type' => $typeFilter,
            'device.check_point.sub_zones',
            'analogous_reports' => $reportsFilter,
            'consumptions'
        ])->get();
    }
}
