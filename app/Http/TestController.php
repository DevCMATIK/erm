<?php

namespace App\Http;

use App\App\Controllers\Soap\SoapController;
use App\App\Jobs\DGA\RestoreReports;
use App\App\Jobs\DGA\RestoreToDGA;
use App\App\Traits\ERM\HasAnalogousData;
use App\Domain\Client\CheckPoint\CheckPoint;
use App\Domain\Client\CheckPoint\DGA\CheckPointReport;
use App\Domain\Data\Analogous\AnalogousReport;
use App\Domain\WaterManagement\Device\Sensor\Sensor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;


class TestController extends SoapController
{
    use HasAnalogousData;

    public $current_date = '2020-12-01';


    public function __invoke(Request $request)
    {

        $checkpoint = CheckPoint::find(69);

        $sensors = $this->getSensors($checkpoint->id);
        dd($sensors);
        $analogous_reports = AnalogousReport::whereIn('sensor_id',$sensors->pluck('id')->toArray())
            ->whereRaw("date between '2021-04-08 00:00:00' and '2021-04-08 23:59:00'")->get();

       $tote =  $analogous_reports->where('sensor_id',$this->getToteSensor($sensors)->id)
            ->where("date", '>=','2021-04-08 00:00:00')->where('date','<=','2021-04-08 23:59:00')
            ->first()->result ?? 0;

        $flow =  $analogous_reports->where('sensor_id',$this->getFlowSensor($sensors)->id)
                ->where("date", '>=','2021-04-08 00:00:00')->where('date','<=','2021-04-08 23:59:00')
                ->first()->result ?? 0;

        $level =  $analogous_reports->where('sensor_id',$this->getLevelSensor($sensors)->id)
                ->where("date", '>=','2021-04-08 00:00:00')->where('date','<=','2021-04-08 23:59:00')
                ->first()->result ?? 0;

        RestoreToDGA::dispatch($tote,$flow,$level,$checkpoint->work_code,$checkpoint,'2021-04-08 12:00:00')->onQueue('long-running-queue-low');

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
