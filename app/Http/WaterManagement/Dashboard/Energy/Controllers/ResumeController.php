<?php

namespace App\Http\WaterManagement\Dashboard\Energy\Controllers;

use App\App\Traits\ERM\HasAnalogousData;
use App\Domain\Client\Zone\Zone;
use App\Domain\WaterManagement\Device\Sensor\Electric\ElectricityConsumption;
use App\Domain\WaterManagement\Device\Sensor\Sensor;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ResumeController extends Controller
{
    use HasAnalogousData;

    public function index($zone_id)
    {
        $zone = Zone::with('sub_zones.consumptions')->find($zone_id);
        $consumptions = array();
        $con = array();

        foreach($zone->sub_zones->sortBy('name') as $sub_zone) {
            $monthly = $this->getMonthlyTotal($sub_zone);
            $yesterday = $this->getYesterdayConsumption($sub_zone);
            array_push($consumptions,[
                $sub_zone->name => [
                    'this-year' => $this->getThisYearTotal($sub_zone)->toArray(),
                    'monthly' => $monthly->toArray(),
                    'this-month' => $monthly->where('month',now()->format('Y-m'))->first()->toArray(),
                    'yesterday' => $yesterday->consumption,
                    'today' => $this->getTodayConsumption($sub_zone,$yesterday->last_read)
                ]
            ]);
        }
        foreach($zone->sub_zones->sortBy('name') as $sub_zone) {
            $monthly = $this->getMonthlyTotalCon($sub_zone);
            //$yesterday = $this->getYesterdayConsumption($sub_zone);
            array_push($con,
                [
                    $sub_zone->name => $monthly->toArray()
                ]
            );
        }
        $con = collect($con)->collapse();
        $months = array_keys(collect($con->first())->collapse()->toArray());
        $years = collect($months)->map(function($month){
            return explode('-',$month)[0];
        })->unique();

        return view('water-management.dashboard.energy.resume', [
            'zone' => $zone,
            'consumptions' => collect($consumptions),
            'months' => $months,
            'sub_zones' => $zone->sub_zones->map(function($item){
                return str_replace(' TG-1','',str_replace(' TG-2','',$item->name));
            })->unique()->toArray(),
            'years' => $years
        ]);
    }

    protected function getMonthlyTotalCon($sub_zone)
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

    public function chartData(Request $request,$zone_id)
    {
        $data['series'] = array();
        array_push($data['series'] , [
            'name' => "Consumo Energía Mensual",
            'data' => $this->makeSeries($request,$zone_id),
        ]) ;

        return json_encode($data,JSON_NUMERIC_CHECK);
    }

    protected function makeSeries(Request $request,$zone_id)
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
        $consumptions = collect($consumptions)->collapse();
        $rows = array();
        if($request->sub_zone != '') {
            foreach ($consumptions as $sub_zone => $consumption) {
                $name = str_replace(' TG-1','',str_replace(' TG-2','',$sub_zone));
                foreach(collect($consumption) as $key => $data) {
                    if($row = collect($rows)->where('sub_zone',$name)->where('month',$key)->first()) {
                        $rows =  collect($rows)->map(function($item) use($name,$data,$key){
                            if($item['sub_zone'] == $name && $item['month'] == $key) {
                                return [
                                    'sub_zone' => $name,
                                    'month' => $key,
                                    'consumption' => $item['consumption'] +$data,
                                ];
                            } else {
                                return $item;
                            }
                        })->toArray();
                    } else {
                        array_push($rows,[
                            'sub_zone' => $name,
                            'month' => $key,
                            'consumption' => $data
                        ]);
                    }

                }
            }
            $rows = collect($rows)->where('sub_zone',$request->sub_zone);
        } else {
            foreach ($consumptions as $sub_zone => $consumption) {
                foreach (collect($consumption) as $key => $data) {
                    if ($row = collect($rows)->where('month', $key)->first()) {
                        $rows = collect($rows)->map(function ($item) use ($data, $key) {
                            if ($item['month'] == $key) {
                                return [
                                    'month' => $key,
                                    'consumption' => $item['consumption'] + $data,
                                ];
                            } else {
                                return $item;
                            }
                        })->toArray();
                    } else {
                        array_push($rows, [
                            'month' => $key,
                            'consumption' => $data
                        ]);
                    }

                }
            }
        }
        $rows = collect($rows)->whereIn('month',$request->months);

        $array = array();
        foreach ($rows as $key => $row) {
            array_push($array, [
                'x' => (strtotime($row['month'].'-01'))*1000,
                'y' => (int)$row['consumption'],
                'name' => $row['month']
            ]);

        }
        return $array;
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
            ->get();
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
