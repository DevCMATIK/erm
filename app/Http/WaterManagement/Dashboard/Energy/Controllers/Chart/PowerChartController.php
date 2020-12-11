<?php

namespace App\Http\WaterManagement\Dashboard\Energy\Controllers\Chart;

use App\App\Traits\ERM\HasAnalogousData;
use App\Domain\Data\Analogous\AnalogousReport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;

class PowerChartController extends Controller
{
    use HasAnalogousData;

    public function __invoke(Request $request,$sub_zone)
    {

        $data =array();

        if($request->type == 'PL') {
            $type = 'ee-p-act-u';
            $names = ['P1','P2','P3'];
            $sensors = $this->getSensorsBySubZoneAndNames($sub_zone,$type,$names);
        } else {
            $type = $request->type;
            $sensors = $this->getSensorsBySubZoneAndType($sub_zone,$type);
        }


        $query = AnalogousReport::with([
            'sensor.type',
            'sensor.dispositions',
            'sensor.selected_disposition'
        ])->whereIn('sensor_id',$sensors->pluck('id')->toArray())
            ->orderBy('date');

        $start = Carbon::parse($request->start)->startOfDay()->toDateTimeString();
        $end = Carbon::parse($request->end)->endOfDay()->toDateTimeString();

        $query = $query->whereRaw("`date` between '{$start}' and '{$end}'");

            $data['title'] = "";


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
            if($name  = $row->sensor->name == 'P1') {
                $data['unit'] = $disposition->unit->name;
                $data['title'] = 'Potencia Líneas';
                $name = 'PL';
            } else {
                $data['unit'] = $disposition->unit->name;
                $data['title'] = 'Potencia '.$row->sensor->name;
            }

            $data['yAxis'] = [
                'title' => [
                    'text' => $name.' ('.$disposition->unit->name.')'
                ],
                'stackLabels' => [
                    'enabled' => true,
                    'style' => [
                        'fontWeight' => 'bold',
                        'color'=>'gray'
                    ]
                ]
            ];

            foreach($rows->groupBy('sensor.name') as $name => $items){
                array_push($data['series'] , [
                    'name' => $name,
                    'data' => $this->transformData($items),
                    'type' => 'spline',
                    'turboThreshold' => 0
                ]) ;
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
                'y' => $row->avg('result'),
                'name' => Carbon::parse($key)->toDateTimeString()
            ]);
        }



        return $array;
    }
}
