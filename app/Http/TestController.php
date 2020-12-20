<?php

namespace App\Http;

use App\App\Controllers\Controller;
use App\App\Controllers\Soap\InstanceSoapClient;
use App\App\Controllers\Soap\SoapController;
use App\App\Traits\ERM\HasAnalogousData;
use App\Domain\Client\CheckPoint\CheckPoint;
use App\Domain\WaterManagement\Device\Device;
use Carbon\Carbon;
use Sentinel;
use SoapHeader;


class TestController extends SoapController
{
    use HasAnalogousData;

    public function __invoke()
    {
        $time_start = microtime(true);

        $checkPoints = $this->getCheckPoints(1);
        $chks = array();
        foreach($checkPoints as $checkPoint)
        {
            $sensors = $this->getSensors($checkPoint);
            dd($sensors);

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

    protected function getWaterLevelSensor()
    {
        return ['tx-nivel'];
    }

    protected function getToteSensor()
    {
        return [
            'totalizador-dga-arkon-modbus',
            'totalizador-dga-siemens-modbus',
            'totalizador-dga-wellford-modbus',
            'totalizador-dga-wellford-pulsos'
        ];
    }


    protected function getFlowSensor()
    {
        return [
            'caudal-dga-arkon-modbus',
            'caudal-dga-siemens-modbus',
            'caudal-dga-wellford-corriente',
            'caudal-dga-wellford-modbus',
        ];
    }




}
