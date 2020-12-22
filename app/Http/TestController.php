<?php

namespace App\Http;

use App\App\Controllers\Controller;
use App\App\Controllers\Soap\InstanceSoapClient;
use App\App\Controllers\Soap\SoapController;
use App\App\Traits\ERM\HasAnalogousData;
use App\Domain\Client\CheckPoint\CheckPoint;
use App\Domain\WaterManagement\Device\Device;
use App\Domain\WaterManagement\Device\Sensor\Sensor;
use App\Http\WaterManagement\Dashboard\Alarm\Traits\HasAlarmTrait;
use Carbon\Carbon;
use Sentinel;
use SoapHeader;


class TestController extends SoapController
{
    use HasAnalogousData;

    public function __invoke()
    {
        $time_start = microtime(true);

        $first_date = now()->subDay()->toDateString();
        $second_date = now()->toDateString();
        $checkPoints = $this->getCheckPoints(1);
        $chks = array();
        foreach($checkPoints as $checkPoint)
        {
            if(!isset($checkPoint->last_report) || $this->calculateTimeSinceLastReport($checkPoint) > 40) {
                $sensors = $this->getSensors($checkPoint);
                $tote = $this->getToteSensor($sensors);
                $flow = $this->getFlowSensor($sensors);
                $level = $this->getLevelSensor($sensors);
                if($tote && $flow && $level) {
                    if(optional($tote->dispositions)->first() && optional($flow->dispositions)->first() && optional($level->dipositions)->first) {

                        $chks[] = [
                            $tote->toArray(),
                            $flow->toArray(),
                            $level->toArray(),
                            $this->getAnalogousValue($tote, true),
                            $this->getAnalogousValue($flow, true),
                            ($this->getAnalogousValue($level, true) * -1),
                            $checkPoint->work_code,
                            $checkPoint
                        ];
                    }
                } else {
                    continue;
                }
            }
        }

        $time_end = microtime(true);

        $execution_time = ($time_end - $time_start);

        dd($execution_time,$chks);

    }

    protected function getSensors($checkPoint)
    {
        return $this->getSensorsByCheckPoint($checkPoint->id)
            ->whereIn('type_id',function($query){
                $query->select('id')->from('sensor_types')
                    ->whereIn('slug',[
                        'tx-nivel',
                        'caudal-dga-arkon-modbus',
                        'caudal-dga-siemens-modbus',
                        'caudal-dga-wellford-corriente',
                        'caudal-dga-wellford-modbus',
                        'totalizador-dga-arkon-modbus',
                        'totalizador-dga-siemens-modbus',
                        'totalizador-dga-wellford-modbus',
                        'totalizador-dga-wellford-pulsos'
                    ]);
            })->get();
    }

    protected function getLevelSensor($sensors)
    {
        return $sensors->filter(function($sensor) {
            return $sensor->type->whereIn('slug',['tx-nivel']);
        })->first();
    }

    protected function getToteSensor($sensors)
    {
        return $sensors->filter(function($sensor) {
            return $sensor->type->whereIn('slug',[
                'totalizador-dga-arkon-modbus',
                'totalizador-dga-siemens-modbus',
                'totalizador-dga-wellford-modbus',
                'totalizador-dga-wellford-pulsos'
            ]);
        });

    }

    protected function getFlowSensor($sensors)
    {
        return $sensors->filter(function($sensor) {
            return $sensor->type->whereIn('slug',[
                'caudal-dga-arkon-modbus',
                'caudal-dga-siemens-modbus',
                'caudal-dga-wellford-corriente',
                'caudal-dga-wellford-modbus'
            ]);
        });

    }


    protected function getCheckPoints($dga_report)
    {
        return  CheckPoint::with('last_report')
                    ->whereNotNull('work_code')
                    ->where('dga_report',1)
                    ->get();
    }

    protected function calculateTimeSinceLastReport($check_point)
    {
        return Carbon::now()->diffInMinutes(Carbon::parse($check_point->last_report->report_date));
    }






}
