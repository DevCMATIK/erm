<?php

namespace App\Http\WaterManagement\Dashboard\Energy\Controllers;

use App\App\Traits\ERM\HasAnalogousData;
use App\Domain\Client\Zone\Zone;
use App\Domain\WaterManagement\Device\Sensor\Electric\ElectricityConsumption;
use App\Domain\WaterManagement\Device\Sensor\Sensor;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ResumePowerBIController extends Controller
{
    use HasAnalogousData;

    public function __invoke($zone_id)
    {
        $zone = Zone::with('sub_zones.consumptions')->find($zone_id);
        $consumptions = array();

        foreach($zone->sub_zones->sortBy('name') as $sub_zone) {
            $monthly = $this->getMonthlyTotal($sub_zone);
            //$yesterday = $this->getYesterdayConsumption($sub_zone);
            array_push($consumptions,
                [
                    $sub_zone->name => $monthly->toArray()
                ]
            );
        }
        $consumptions = collect($consumptions);
        $rows = array();
        foreach ($consumptions as $sub_zone => $consumption) {
            $name = str_replace(' TG-1','',str_replace(' TG-2','',$sub_zone));
            foreach(collect($consumption)->collapse() as $key => $data) {
                if($key !== 'this-year') {
                    if(!isset($rows[$name][$key])) {
                        $rows[$name][$key] = $data;
                    } else  {
                        $rows[$name][$key] += $data;
                    }
                }
            }
        }
        dd($rows);
        return view('water-management.dashboard.energy.power-bi', [
            'zone' => $zone,
            'rows' => collect($rows)->map(function($column,$index){
                return array_values(collect($column)->map(function($col,$month) use($index){
                    return [
                        $index,$col['consumption'],$col['month']
                    ];
                })->toArray());
            })->collapse(),
        ]);
    }

    protected function getTodayConsumption($sub_zone,$last_read)
    {
        $sensor = Sensor::
        with(['device.report','dispositions.unit'])
            ->find($sub_zone->consumptions
                ->where('sensor_type')
                ->first()
                ->sensor_id
            );
        $value = $this->getAnalogousValue($sensor);

        return number_format( ($value['value'] - $last_read),2);
    }

    protected function getYesterdayConsumption($sub_zone)
    {
        return $sub_zone->consumptions
            ->where('sensor_type','ee-e-activa')
            ->where('date',now()->subDay()
                ->toDateString())->first();

    }

    protected function getMonthlyTotal($sub_zone)
    {
        return ElectricityConsumption::select(
            DB::raw('sum(consumption) as consumption'),
            DB::raw("DATE_FORMAT(date,'%Y-%m') as month")
        )->where('sensor_type','ee-e-activa')
            ->where('sub_zone_id',$sub_zone->id)
            ->groupBy('month')
            ->get()->map(function($item){
                return [
                    $item['month'] => $item['consumption']
                ];
            });
    }

    protected function getThisYearTotal($sub_zone)
    {
        return $this->getByYearTotal($sub_zone)->where('year',now()->year)->first();
    }

    protected function getByYearTotal($sub_zone)
    {
        return ElectricityConsumption::select(
            DB::raw('sum(consumption) as consumption'),
            DB::raw("DATE_FORMAT(date,'%Y') as year")
        )->where('sensor_type','ee-e-activa')
            ->where('sub_zone_id',$sub_zone->id)
            ->groupBy('year')
            ->get();
    }
}
