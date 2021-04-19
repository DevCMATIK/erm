<?php

namespace App\Http;

use App\App\Controllers\Soap\SoapController;
use App\App\Traits\ERM\HasAnalogousData;
use App\Domain\Client\CheckPoint\CheckPoint;
use App\Domain\Client\CheckPoint\DGA\CheckPointReport;
use App\Domain\Client\Zone\Zone;
use App\Domain\Data\Analogous\AnalogousReport;
use App\Domain\WaterManagement\Device\Sensor\Electric\ElectricityConsumption;
use App\Domain\WaterManagement\Device\Sensor\Sensor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;


class TestController extends SoapController
{
    use HasAnalogousData;

    public $current_date = '2020-12-01';


    public function __invoke()
    {
        $reports = CheckPointReport::where('check_point_id',77)
            ->where('response',0)->whereRaw("report_date between '2021-03-01 00:00:00' and '2021-04-18 23:59:00'")->get()->groupBy(function($item){
                return Carbon::parse($item->report_date)->format('Y-m-d');
            })->filter(function($item, $key) {
                return count($item) < 24;
            });
        $checkpoint = CheckPoint::find(77);
        $missing = array();
        $sensors = $this->getSensors(77);

        foreach($reports as $day => $report)
        {
            $report_day = array();
            for ($i = 1;$i<25;$i++) {
                $hour = str_pad($i,2,"0",STR_PAD_LEFT);
                if(!$report
                    ->where(
                        'report_date',
                        '>=',
                        $day.' '.$hour.':00:00'
                    )->where(
                        'report_date',
                        '<=',
                        $day .' '.$hour.':59:59'
                    )->first()) {
                    array_push($report_day,[
                        'start_hour' => $hour.':00:00',
                        'end_hour' => $hour.':59:59'
                    ]);
                }
            }
            array_push($missing,[$day => $report_day]);
        }
        $dates =collect($missing)->map(function($item,$key){
            return array_keys($item);
        })->collapse();

        $first_date = collect($dates)->first();
        $last_date = collect(array_reverse($dates->toArray()))->first();

        $analogous_reports = AnalogousReport::whereIn('sensor_id',$sensors->pluck('id'))
            ->whereRaw("date between '{$first_date} 00:00:00' and '{$last_date} 23:59:00'")->get();

        foreach($missing as  $miss) {
            foreach($miss as $day => $items) {
                $toRestore = array();
                $values = array();
              foreach($items as $hours) {
                  $start_date = $day.' '.$hours['start_hour'];
                  $end_date = $day.' '.$hours['end_hour'];
                  array_push($values, [
                      'work_code' => $checkpoint->work_code,
                      'tote' => $analogous_reports->where('sensor_id',$this->getToteSensor($sensors)->id)
                              ->where("date", '>=',$start_date)->where('date','<=',$end_date)
                              ->first()->data ?? null,
                      'flow' => $analogous_reports->where('sensor_id',$this->getFlowSensor($sensors)->id)
                              ->where("date", '>=',$start_date)->where('date','<=',$end_date)
                              ->first()->data ?? null,
                      'level' => $analogous_reports->where('sensor_id',$this->getLevelSensor($sensors)->id)
                              ->where("date", '>=',$start_date)->where('date','<=',$end_date)
                              ->first()->data ?? null
                  ]);
              }
              array_push($toRestore,[$day => $values]);
           }
        }


        return $this->testResponse([$toRestore,$sensors]);
    }
    protected function getSensors($checkPoint)
    {
        return $this->getSensorsByCheckPoint($checkPoint)
            ->whereIn('type_id',function($query){
                $query->select('id')->from('sensor_types')
                    ->where('is_dga',1)
                    ->whereIn('sensor_type',[
                        'tote',
                        'level',
                        'flow',
                    ]);
            })->get();
    }

    protected function getSensorsByCheckPoint($check_point)
    {

        return Sensor::query()->with([
            'device.check_point',
        ]) ->whereIn('address_id', function($query){
            $query->select('id')
                ->from('addresses')
                ->where('configuration_type','scale');
        })->whereIn('device_id',function($query)  use($check_point){
            $query->select('id')
                ->from('devices')
                ->where('check_point_id',$check_point);
        });;
    }

    protected function getLevelSensor($sensors)
    {
        return $sensors->filter(function($sensor) {
            return collect(['level'])->contains($sensor->type->sensor_type);
        })->first();
    }

    protected function getToteSensor($sensors)
    {
        return $sensors->filter(function($sensor) {
            return collect(['tote'
            ])->contains($sensor->type->sensor_type);
        })->first();

    }

    protected function getFlowSensor($sensors)
    {
        return $sensors->filter(function($sensor) {
            return collect(['flow'
            ])->contains($sensor->type->sensor_type);
        })->first();

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
