<?php

namespace App\Http;

use App\App\Controllers\Soap\SoapController;
use App\App\Jobs\DGA\RestoreReports;
use App\App\Jobs\DGA\RestoreToDGA;
use App\App\Traits\ERM\HasAnalogousData;
use App\Domain\Client\CheckPoint\CheckPoint;
use App\Domain\Client\CheckPoint\DGA\CheckPointReport;
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

        $checkpoints = CheckPoint::where('dga_report',2)
            ->get();

        $reports = CheckPointReport::with('check_point')->whereIn('check_point_id',$checkpoints->pluck('id')->toArray())
            ->whereRaw("report_date between '2021-04-08 00:00:00' and '2021-04-08 23:59:00'")->get();

        foreach($reports as $report) {
            $level = $report->water_table_reported * -1;
            RestoreToDGA::dispatch(
                $report->tote_reported ?? 0,
                $report->flow_reported ?? 0,
                $level ?? 0,
                $report->check_point->work_code,
                $report->check_point,
                $report->report_date
            )->onQueue('long-running-queue-low');
        }

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
