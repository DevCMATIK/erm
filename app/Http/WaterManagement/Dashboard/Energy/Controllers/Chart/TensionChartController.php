<?php

namespace App\Http\WaterManagement\Dashboard\Energy\Controllers\Chart;

use App\App\Traits\ERM\HasAnalogousData;
use App\Domain\Data\Analogous\AnalogousReport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;

class TensionChartController extends Controller
{
    use HasAnalogousData;

    public function __invoke(Request $request,$sub_zone)
    {
        $data =array();

        if($request->type == 'LL') {
            $type = 'ee-tension-l-l';
            if($request->options == 'average') {
                $names = ['L-L Avr'];
            } else {
                $names = ['L1-L2','L2-L3','L3-L1'];
            }

        } else {
            $type = 'ee-tension-l-n';
            if($request->options == 'average') {
                $names = ['L-N Avr'];
            } else {
                $names = ['L1-N','L2-N','L3-N'];
            }
        }

        $sensors = $this->getSensorsBySubZoneAndNames($sub_zone,$type,$names);

        $query = AnalogousReport::with([
            'sensor.type',
            'sensor.dispositions',
            'sensor.selected_disposition'
        ])->whereIn('sensor_id',$sensors->pluck('id')->toArray())
            ->orderBy('date');

        $start = Carbon::parse($request->start)->startOfDay()->toDateTimeString();
        $end = Carbon::parse($request->end)->endOfDay()->toDateTimeString();

        $query = $query->whereRaw("`date` between '{$start}' and '{$end}'");


        if(Carbon::parse($end)->diffInDays(Carbon::parse($start)) == 1) {
            $data['tick'] = 1000 * 60 * 60;
        } else {
            $data['tick'] = 1000 * 60 * 60*24;
        }


        $rows = $query->get();
        $data['series'] = array();

        if(count($rows) > 0) {
            $row = $rows->first();

            if(!$disposition = $row->sensor->selected_disposition->first()) {
                $disposition = $row->sensor->dispositions()->first();
            }
            if($request->options == 'average') {
                $titl = $row->sensor->name.' ('.$disposition->unit->name.')';
            } else {
                $titl = $request->type.' ('.$disposition->unit->name.')';
            }

            $data['unit'] = $disposition->unit->name;
            $data['yAxis'] = [
                'title' => [
                    'text' => $titl
                ],
                'stackLabels' => [
                    'enabled' => true,
                    'style' => [
                        'fontWeight' => 'bold',
                        'color'=>'gray'
                    ]
                ]
            ];
            if($request->type == 'LL') {
                $data['title']  = 'Tensión LL';
            } else {
                $data['title'] = 'Tensión LN';
            }
            if($request->options == 'average') {
                array_push($data['series'] , [
                    'name' => $row->sensor->name,
                    'data' => $this->transformData($rows),
                    'type' => 'spline',
                    'turboThreshold' => 0
                ]) ;
            } else {
                foreach($rows->groupBy('sensor.name') as $name => $items){
                    array_push($data['series'] , [
                        'name' => $name,
                        'data' => $this->transformData($items),
                        'type' => 'spline',
                        'turboThreshold' => 0
                    ]) ;
                }
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
                'y' => number_format($row->avg('result'),2),
                'name' => Carbon::parse($key)->toDateTimeString()
            ]);
        }



        return $array;
    }
}
