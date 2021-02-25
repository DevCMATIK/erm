<?php

namespace App\Http;

use App\App\Controllers\Soap\SoapController;
use App\App\Jobs\SendToDGA;
use App\App\Traits\ERM\HasAnalogousData;
use App\Domain\Client\CheckPoint\CheckPoint;
use App\Domain\Client\CheckPoint\DGA\CheckPointReport;
use App\Domain\Client\Zone\Zone;
use App\Domain\Data\Analogous\AnalogousReport;
use App\Domain\WaterManagement\Device\Sensor\Sensor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Sentinel;


class TestController extends SoapController
{
    use HasAnalogousData;

    public $current_date = '2020-12-01';


    public function __invoke(Request $request)
    {
        $sensor_id = $request->sensor_id;
        $device_id = $request->device_id;
        $s = array($sensor_id);
        if($request->has('sensors')) {
            $ss = array_merge($s,$request->sensors);
        } else {
            $ss = $s;
        }

        $data =array();
        $data['series'] =array();
        $types  = Sensor::with([
            'dispositions.lines',
            'selected_disposition.lines',
            'type.interpreters'
        ])->whereIn('id',$ss)->get()->groupBy('type_id');
        $yAxis = array();
        $i = 0;
        foreach($types as $sensors) {
            if($i === 0) {
                $opposite = false;
            } else {
                $opposite = true;
            }
            array_push($yAxis,[
                'title' => [
                    'text' => $sensors->first()->name
                ],
                'stackLabels' => [
                    'enabled' => true,
                    'style' => [
                        'fontWeight' => 'bold',
                        'color'=>'gray'
                    ]
                ],
                'opposite' => $opposite,
                'plotLines' => [],
                'plotBands' => [],
                'min' =>  ''
            ]);
            foreach($sensors as $sensor) {
                if ($request->has('date') && $request->date != '') {
                    $query = AnalogousReport::with('sensor')->where('device_id',$device_id)
                        ->where('sensor_id',$sensor->id)
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
                    $query = AnalogousReport::with('sensor')->where('device_id',$device_id)
                        ->where('sensor_id',$sensor->id)
                        ->whereRaw('date > date_sub(now(),interval 7 day)')
                        ->orderBy('date');
                }


                $rows = $query->get();


                if(count($rows) > 0) {
                    $row = $rows->first();
                    $data['unit'] = $row->unit;
                    if(!$disposition = $sensor->selected_disposition()->first()) {
                        $disposition = $sensor->dispositions()->first();
                    }
                    if($i === 0) {
                        if($rows->first()->sensor->type->id == 1 && strtolower($rows->first()->unit == 'mt')) {
                            $max_value = (float)$rows->first()->sensor->max_value;
                            array_push($yAxis[0]['plotLines'], [
                                'value' => $max_value,
                                'color' => "black",
                                'dashStyle' => 'shortdash',
                                'width' => 2,
                                'zIndex' => 5,
                                'label' => [
                                    'text' => 'Ubicación Bomba ' . $max_value . ' MT'
                                ]
                            ]);
                            array_push($yAxis[0]['plotLines'], [
                                'value' => ($max_value + 10),
                                'color' => "red",
                                'dashStyle' => 'shortdash',
                                'width' => 2,
                                'zIndex' => 5,
                                'label' => [
                                    'text' => 'Nivel Mínimo ' . ($max_value + 10) . ' MT'
                                ]
                            ]);
                            $yAxis[0]['min'] = $max_value - 5;
                        } else {
                            $yAxis[0]['min'] = null;
                        }

                        if($rows->first()->sensor->device->check_point->type->slug == 'copas') {
                            $ranges = $row->first()->sensor->ranges()->get();
                            if(count($ranges) > 0 ){
                                foreach($ranges as $range) {
                                    if($range->color == 'warning') {
                                        $colorBand = 'rgba(255, 217, 80,0.1)';
                                    } else if($range->color == 'danger' ){
                                        $colorBand ='rgba(217, 83, 79, 0.1)';
                                    } else {
                                        $colorBand = 'rgba(2, 188, 119, 0.1)';
                                    }

                                    array_push($yAxis[0]['plotBands'], [
                                        'from' => $range->min,
                                        'to' => $range->max,
                                        'color' => $colorBand,
                                        'zIndex' => 1,
                                    ]);
                                }
                            }
                        }

                        foreach($disposition->lines as $line) {
                            if($line->chart == 'default') {
                                array_push($yAxis[0]['plotLines'],[
                                    'value' => $line->value,
                                    'color' => "{$line->color}",
                                    'dashStyle' => 'shortdash',
                                    'width' => 2,
                                    'label' => [
                                        'text' => $line->text.' : '.$line->value.' '.$row->unit
                                    ]
                                ]);

                            }
                        }
                    }

                    array_push($data['series'] , [
                        'name' => $sensor->name.' ('.$disposition->unit->name.')',
                        'data' => $this->transformData($rows),
                        'turboThreshold' => 0,
                        'type' => 'spline',
                        'yAxis' => $i,
                        'zIndex' => $i + 100
                    ]) ;

                }
            }
            $i++;

        }
        $data['yAxis'] = $yAxis;
        return $this->testResponse([1]);
    }

    protected function transformData($rows){
        $array = array();
        if (stristr($rows->first()->sensor->name,'Aporte')  ) {
            foreach ($rows as $key => $row) {
                if($row->result >0) {
                    array_push($array, [
                        'x' => (strtotime($row->date))*1000,
                        'y' => (integer)number_format($row->result,0,'',''),
                        'name' => $row->date
                    ]);
                }

            }

        }else {
            foreach ($rows as $key => $row) {
                array_push($array, [
                    'x' => (strtotime($row->date))*1000,
                    'y' => (float)number_format($row->result,2,'.',''),
                    'name' => $row->date
                ]);
            }
        }


        return $array;
    }
    public function testResponse($results)
    {
        return response()->json(array_merge(['results' => $results],$this->getExecutionTime()));
    }

    public function getExecutionTime()
    {
        return [
            'time_in_seconds' => (microtime(true) - LARAVEL_START)
        ];
    }
}
