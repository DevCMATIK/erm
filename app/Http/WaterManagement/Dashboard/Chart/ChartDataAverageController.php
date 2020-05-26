<?php

namespace App\Http\WaterManagement\Dashboard\Chart;

use App\Domain\Data\Analogous\AnalogousReport;
use App\Domain\WaterManagement\Device\Sensor\Behavior\SensorBehavior;
use App\Domain\WaterManagement\Device\Sensor\Sensor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;

class ChartDataAverageController extends Controller
{
    public function __invoke(Request $request,$device_id,$sensor_id)
    {
        $data =array();
        $s = Sensor::with([
            'dispositions.lines',
            'selected_disposition.lines'
        ])->find($sensor_id);
            if ($request->has('date') && $request->date != '') {
                $query = SensorBehavior::with('sensor')
                    ->where('sensor_id',$sensor_id)
                    ->orderBy('date');
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
                $query = SensorBehavior::with('sensor')
                    ->where('sensor_id',$sensor_id)
                    ->whereRaw('date > date_sub(now(),interval 7 day)')
                    ->orderBy('date');
            }


        $rows = $query->get();

        $data['series'] = array();

        if(count($rows) > 0) {
            $row = $rows->first();
            $data['unit'] = 'MT';
            if(!$disposition = $s->selected_disposition()->first()) {
                $disposition = $s->dispositions()->first();
            }
            $data['plotLines'] = array();
                $max_value = $s->max_value;
                array_push($data['plotLines'], [
                    'value' => $max_value,
                    'color' => "black",
                    'dashStyle' => 'shortdash',
                    'width' => 2,
                    'zIndex' => 5,
                    'label' => [
                        'text' => 'Ubicación Bomba '.$max_value.' MT'
                    ]
                ]);
                array_push($data['plotLines'], [
                    'value' => ($max_value + 10),
                    'color' => "red",
                    'dashStyle' => 'shortdash',
                    'width' => 2,
                    'zIndex' => 5,
                    'label' => [
                        'text' => 'Nivel Mínimo '.($max_value + 10).' MT'
                    ]
                ]);
                $data['min_value'] = $max_value - 5;
            foreach($disposition->lines as $line) {
                if($line->chart == 'averages') {
                    array_push($data['plotLines'],[
                        'value' => $line->value,
                        'color' => "{$line->color}",
                        'dashStyle' => 'shortdash',
                        'width' => 2,
                        'label' => [
                            'text' => $line->text.' : '.$line->value.' MT'
                        ]
                    ]);

                }
            }
            array_push($data['series'] , [
                'name' => 'Estático',
                'data' => $this->transformData($rows->filter(function($item){
                    return $item->static_level != null;
                }),'static_level'),
                'type' => 'spline',
                'turboThreshold' => 0
            ]) ;



            array_push($data['series'] , [
                'name' => 'Dinámico',
                'data' => $this->transformData($rows->filter(function($item){
                    return $item->dynamic_level != null;
                }),'dynamic_level'),
                'type' => 'spline',
                'turboThreshold' => 0
            ]) ;




            return json_encode($data,JSON_NUMERIC_CHECK);
        } else {
            return null;
        }

    }

    protected function transformData($rows,$var){
        $array = array();

            foreach ($rows as $key => $row) {
                array_push($array, [
                    'x' => (strtotime($row->date))*1000,
                    'y' => (float)number_format($row->{$var},2),
                    'name' => $row->date
                ]);
            }



        return $array;
    }
}
