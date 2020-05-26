<?php

namespace App\Http\WaterManagement\Dashboard\Chart\Electric;

use App\Domain\WaterManagement\Device\Sensor\Electric\ElectricityConsumption;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;

class EnergyChartController extends Controller
{
    public function __invoke(Request $request,$sub_zone_id)
    {
        $data =array();

        if($request->date == 'thisWeek') {
                $from = Carbon::now()->startOfWeek()->toDateString();
                $from2 = Carbon::now()->startOfWeek()->subWeek()->toDateString();
                $to = Carbon::now()->endOfWeek()->toDateString();
                $to2 = Carbon::now()->endOfWeek()->subWeek()->toDateString();
                $data['title'] = "Consumo esta Semana";
                $data['pointWidth'] = 20;
        } else {
                $from = Carbon::now()->startOfMonth()->toDateString();
                $from2 = Carbon::now()->startOfMonth()->subMonth()->toDateString();
                $to = Carbon::now()->endOfMonth()->toDateString();
                $to2 = Carbon::now()->endOfMonth()->subMonth()->toDateString();
                $data['title'] = "Consumo este Mes";
                $data['pointWidth'] = 10;
        }
        $s = ElectricityConsumption::with([
            'sensor.dispositions.unit',
            'sensor.selected_disposition.unit',
            'sub_zone'
        ])->where('sub_zone_id',$sub_zone_id)->whereRaw("`date` between '{$from}' and '{$to}'")->where('sensor_type','ee-e-activa')->orderBy('date');
        $ss = ElectricityConsumption::with([
            'sensor.dispositions.unit',
            'sensor.selected_disposition.unit',
            'sub_zone'
        ])->where('sub_zone_id',$sub_zone_id)->whereRaw("`date` between '{$from2}' and '{$to2}'")->where('sensor_type','ee-e-activa')->orderBy('date');




        if(Carbon::parse($to)->diffInDays(Carbon::parse($from)) == 1) {
            $data['tick'] = 1000 * 60 * 60;
        } else {
            $data['tick'] = 1000 * 60 * 60 * 24;
        }



        $rows = $s->get();
        $rows2 = $ss->get();

        $data['series'] = array();

        if(count($rows) > 0 || count($rows2) > 0) {
            if(count($rows) > 0) {
                $row = $rows->first();
            } else {
                $row = $rows2->first();
            }

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
                    'name' => 'Consumo actual',
                    'data' => $this->transformData($rows),
                    'type' => 'column',
                    'turboThreshold' => 0
                ]);
            }
            if(count($rows2) > 0) {
                array_push($data['series'] , [
                    'name' => 'Consumo anterior',
                    'data' => $this->transformData2($request->date,$rows2),
                    'type' => 'column',
                    'turboThreshold' => 0
                ]);
            }


            return json_encode($data,JSON_NUMERIC_CHECK);
        } else {
            return null;
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

    protected function transformData2($date,$rows2){
        $array = array();
        $i= 0;
        foreach ($rows2->groupBy('date') as $key => $row2) {
            if($date == 'thisWeek') {
                $x = Carbon::parse($key)->addWeek()->toDateString();
            } else {
                $x = Carbon::parse($key)->addMonth()->toDateString();
            }
            array_push($array, [
                'x' => (strtotime($x))*1000,
                'y' => $row2->sum('consumption'),
                'name' => Carbon::parse($key)->toDateString()
            ]);
        }



        return $array;
    }
}
