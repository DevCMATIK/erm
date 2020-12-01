<?php

namespace App\Http\WaterManagement\Dashboard\Energy\Controllers\Chart;

use App\Domain\WaterManagement\Device\Sensor\Electric\ElectricityConsumption;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;

class ConsumptionChartController extends Controller
{
    public function __invoke(Request $request,$sub_zone_id)
    {
        $data =array();

        if($request->start == now()->subDays(30)->toDateString() && $request->end == now()->toDateString()) {
            $data['title'] = 'Consumo de energía, últimos 30 días';
        } else {
            $data['title'] = 'Consumo de energía diario';
        }

        $data['pointWidth'] = 20;

        $s = ElectricityConsumption::with([
            'sensor.dispositions.unit',
            'sensor.selected_disposition.unit',
            'sub_zone'
        ])->where('sub_zone_id',$sub_zone_id)->whereRaw("`date` between '{$request->start}' and '{$request->end}'")->where('sensor_type','ee-e-activa')->orderBy('date');


        if(Carbon::parse($request->end)->diffInDays(Carbon::parse($request->start)) == 1) {
            $data['tick'] = 1000 * 60 * 60;
        } else {
            $data['tick'] = 1000 * 60 * 60 * 24;
        }


        $rows = $s->get();

        $data['series'] = array();

        if(count($rows) > 0) {
            $row = $rows->first();

            if(!$disposition = $row->sensor->selected_disposition->first()) {
                $disposition = $row->sensor->dispositions()->first();
            }

            $data['unit'] = $disposition->unit->name;
            $data['yAxis'] = [
                'title' => [
                    'text' => $row->sensor->name.' ('.$disposition->unit->name.')'
                ],
                'stackLabels' => [
                    'enabled' => true,
                    'style' => [
                        'fontWeight' => 'bold',
                        'color'=>'gray'
                    ]
                ]
            ];

            if(count($rows) > 0) {
                array_push($data['series'] , [
                    'name' => 'Consumo',
                    'data' => $this->transformData($rows),
                    'type' => 'column',
                    'turboThreshold' => 0
                ]);
            }


            return json_encode($data,JSON_NUMERIC_CHECK);
        } else {
            return [];
        }
    }

    protected function transformData($rows){
        $array = array();

        foreach ($rows->groupBy('date') as $key => $row) {
            array_push($array, [
                'x' => (strtotime($key))*1000,
                'y' => $row->sum('consumption'),
                'name' => Carbon::parse($key)->toDateString()
            ]);
        }
        return $array;
    }
}
