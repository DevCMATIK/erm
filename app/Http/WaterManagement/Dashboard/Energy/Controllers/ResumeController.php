<?php

namespace App\Http\WaterManagement\Dashboard\Energy\Controllers;

use App\App\Traits\ERM\HasAnalogousData;
use App\Domain\Client\Zone\Sub\MapLine;
use App\Domain\Client\Zone\Sub\SubZone;
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
            if($thisYearTotal = $this->getThisYearTotal($sub_zone)) {
                $thisYearTotal = $thisYearTotal->toArray();
            } else {
                $thisYearTotal = ['consumption' => 0];
            }

            if($thisMonth = $monthly->where('month',now()->format('Y-m'))->first()) {
                $thisMonth = $thisMonth->toArray();
            } else {
                $thisMonth =['consumption' => 0];
            }
            array_push($consumptions,[
                $sub_zone->name => [
                    'this-year' => $thisYearTotal,
                    'monthly' => $monthly->toArray(),
                    'this-month' => $thisMonth,
                    'yesterday' => $yesterday->consumption ?? 0,
                    'today' => $this->getTodayConsumption($sub_zone,$yesterday->last_read ?? 0)
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

        if($zone_id == 11) {
            $subZones = $this->getSubZones($zone_id);
            $lines = $this->getLines($subZones);
        } else {
            $subZones = [];
            $lines = [];
        }
        return view('water-management.dashboard.energy.resume', [
            'zone' => $zone,
            'consumptions' => collect($consumptions),
            'months' => $months,
            'sub_zones' => $zone->sub_zones->map(function($item){
                return str_replace(' TG-1','',str_replace(' TG-2','',$item->name));
            })->unique()->toArray(),
            'subZones' => $subZones,
            'lines' => $lines,
            'years' => $years
        ]);
    }

    protected function getLines($subZones)
    {
        $subZones = collect($subZones);
        return MapLine::with(['p_one','p_two'])->orderBy('position')->get()->map(function($item) use ($subZones) {
            $l = array();

            array_push($l,[
                'lng' => $item->p_one->lng,
                'lat' => $item->p_one->lat
            ]);

            if($item->points_between != null) {
                foreach(json_decode($item->points_between) as $point) {
                    $coords = explode(',',str_replace(' ','',$point));
                    array_push($l,[
                        'lng' => $coords[1],
                        'lat' => $coords[0]
                    ]);
                }
            }

            array_push($l,[
                'lng' => $item->p_two->lng,
                'lat' => $item->p_two->lat
            ]);

            if($subZones->where('id',$item->point_one)->first()['status']['state'] == 1){
                $color = '#6AD252';
            } else {
                $color = '#B2BABB';
            }
            return [
                'lines' => $l,
                'color' => $color
            ];
        });
    }

    protected function getSubZones($id)
    {
        return  SubZone::with('check_points.devices.report')
            ->where('zone_id',$id)
            ->get()
            ->map(function($subZone){
                return [
                    'id' => $subZone->id,
                    'name' => $subZone->name,
                    'lat' => $subZone->lat,
                    'lng' => $subZone->lng,
                    'status' => $subZone->check_points->map(function($checkPoint){
                        $okCount = 0;
                        $offCount = 0;
                        foreach($checkPoint->devices->map(function($device){
                            return $device->report->state;
                        }) as $state){
                            if($state == 0) {
                                $offCount++;
                            } else {
                                $okCount++;
                            }
                        }

                        if($offCount > 0 && $okCount <= 0) {
                            return ['state' => 0, 'color' => '#F74C41' ]; //rojo
                        } elseif ($offCount > 0 && $okCount > 0) {
                            return ['state' => 0, 'color' => '#ACACAC' ]; //plomo
                        } else {
                            return ['state' => 1, 'color' => '#6AD252' ]; //verde
                        }
                    })->toArray()[0]
                ];
            });
    }

    protected function getMonthlyTotalConChart($sub_zone)
    {
        return ElectricityConsumption::select(
            DB::raw('sum(consumption) as consumption'),
            DB::raw('sum(high_consumption) as high_consumption'),
            DB::raw("DATE_FORMAT(date,'%Y-%m') as month")
        )->where('sensor_type','ee-e-activa')
            ->where('sub_zone_id',$sub_zone->id)
            ->groupBy('month')
            ->get()->map(function($item){
                return [
                    $item['month'] => [
                        'consumption' => $item['consumption'] ?? 0,
                        'high' => $item['high_consumption'] ?? 0
                    ]
                ];
            });
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
        $data = array();
        $data['series'] = array();
        $data['yAxis'] = [
            [
                'title' => [
                    'text' => 'Consumo de energía en hora Peak (kWh)'
                ],
                'stackLabels' => [
                    'enabled' => false,
                    'style' => [
                        'fontWeight' => 'bold'
                    ]
                ],
                'zIndex' => 5
            ],
            [
                'title' => [
                    'text' => 'Consumo Energía Activa (kWh)'
                ],
                'stackLabels' => [
                    'enabled' => true,
                    'style' => [
                        'fontWeight' => 'bold',
                        'color'=>'gray'
                    ]
                ],
                'opposite' => true,
                'zIndex' => 100
            ]
        ];
       $data['series'] = $this->makeSeries($request,$zone_id) ;

        return json_encode($data,JSON_NUMERIC_CHECK);
    }

    protected function makeSeries(Request $request,$zone_id)
    {
        $zone = Zone::with('sub_zones.consumptions')->find($zone_id);
        $consumptions = array();
        foreach($zone->sub_zones->sortBy('name') as $sub_zone) {
            $monthly = $this->getMonthlyTotalConChart($sub_zone);
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
                foreach(collect($consumption)->collapse() as $key => $data) {
                    if($row = collect($rows)->where('sub_zone',$name)->where('month',$key)->first()) {
                        $rows =  collect($rows)->map(function($item) use($name,$data,$key){

                            if($item['sub_zone'] == $name && $item['month'] == $key) {
                                return [
                                    'sub_zone' => $name,
                                    'month' => $key,
                                    'consumption' => (float)$item['consumption']['consumption'] + (float)$data['consumption'],
                                    'high' => (float)$item['consumption']['high'] + (float)$data['high'],
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
                foreach (collect($consumption)->collapse() as $key => $data) {
                    if ($row = collect($rows)->where('month', $key)->first()) {
                        $rows = collect($rows)->map(function ($item) use ($data, $key) {

                            if ($item['month'] == $key) {

                                return [
                                    'month' => $key,
                                    'consumption' => $item['consumption'] + $data['consumption'],
                                    'high' => $item['high'] + $data['high'],
                                ];
                            } else {
                                return $item;
                            }
                        })->toArray();
                    } else {
                        array_push($rows, [
                            'month' => $key,
                            'consumption' => $data['consumption'],
                            'high' => $data['high'],
                        ]);
                    }

                }
            }
        }
        $rows = collect($rows)->whereIn('month',$request->months);
        $series = array();
        $normal = array();
        $peak = array();
        $array = array();
        if($request->sub_zone != '') {
            foreach ($rows as $key => $row) {

                array_push($normal, [
                    'x' => (strtotime($row['month'].'-01'))*1000,
                    'y' => (int)$row['consumption']['consumption'] - (int)$row['consumption']['high'],
                    'name' => $row['month']
                ]);

                array_push($peak, [
                    'x' => (strtotime($row['month'].'-01'))*1000,
                    'y' => (int)$row['consumption']['high'],
                    'name' => $row['month']
                ]);

                array_push($array, [
                    'x' => (strtotime($row['month'].'-01'))*1000,
                    'y' => (int)$row['consumption']['consumption'],
                    'name' => $row['month']
                ]);

            }
        } else {
            foreach ($rows as $key => $row) {

                array_push($normal, [
                    'x' => (strtotime($row['month'].'-01'))*1000,
                    'y' => (int)$row['consumption'] - (int)$row['high'],
                    'name' => $row['month']
                ]);

                array_push($peak, [
                    'x' => (strtotime($row['month'].'-01'))*1000,
                    'y' => (int)$row['high'],
                    'name' => $row['month']
                ]);

                array_push($array, [
                    'x' => (strtotime($row['month'].'-01'))*1000,
                    'y' => (int)$row['consumption'],
                    'name' => $row['month']
                ]);

            }
        }


        array_push($series , [
            'name' => 'Consumo horario punta',
            'data' => $peak,
            'type' => 'column',
            'turboThreshold' => 0,
            'yAxis' => 0,
            'zIndex' => 50
        ]);

        array_push($series , [
            'name' => 'Consumo horario normal',
            'data' => $normal,
            'type' => 'column',
            'turboThreshold' => 0,
            'yAxis' => 0,
            'zIndex' => 50
        ]);

        array_push($series , [
            'name' => 'Consumo',
            'data' => $array,
            'type' => 'spline',
            'turboThreshold' => 0,
            'zIndex' => 100,
            'yAxis' => 1,
        ]);
        return $series;
    }


    protected function getTodayConsumption($sub_zone,$last_read)
    {
        $sensor = Sensor::
        with(['device.report','dispositions.unit'])
            ->find($sub_zone->consumptions
                    ->where('sensor_type')
                    ->first()
                    ->sensor_id ?? null
            );
        if($sensor) {
            $value = $this->getAnalogousValue($sensor);
            if(is_array($value )) {
                $val = $value['value'] ;
            } else {
                $val = 0;
            }
            return number_format( ((($last_read == 0)?0:$val) - $last_read),2);
        }

        return 0;
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
