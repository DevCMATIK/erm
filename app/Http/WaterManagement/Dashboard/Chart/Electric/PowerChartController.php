<?php

namespace App\Http\WaterManagement\Dashboard\Chart\Electric;

use App\Domain\Data\Analogous\AnalogousReport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;

class PowerChartController extends Controller
{
    public function __invoke(Request $request)
    {

        $data =array();
        $query = AnalogousReport::with([
            'sensor.type',
            'sensor.dispositions',
            'sensor.selected_disposition'
        ])->whereIn('sensor_id',explode(',',$request->sensors))
            ->orderBy('date');
        if ($request->has('date') && $request->date != '') {
            $dates = explode(' ',$request->date);
            $from = date($dates[0]);
            $to = date($dates[2]);
            $from = Carbon::parse($from)->startOfDay()->toDateTimeString();  //2016-09-29 00:00:00.000000
            $to = Carbon::parse($to)->endOfDay()->toDateTimeString();
            $query = $query->between('date',$from,$to);

            $data['title'] = "";


            if(Carbon::parse($to)->diffInDays(Carbon::parse($from)) == 1) {
                $data['tick'] = 1000 * 60 * 60;
            } else {
                $data['tick'] = 1000 * 60 * 60 * 24;
            }

        } else {
            $query = $query->today('date');
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
