<?php

namespace App\Http;

use App\App\Controllers\Controller;
use App\App\Controllers\Soap\InstanceSoapClient;
use App\App\Controllers\Soap\SoapController;
use App\App\Traits\ERM\HasAnalogousData;
use App\Domain\Client\CheckPoint\CheckPoint;
use App\Domain\WaterManagement\Device\Device;
use App\Domain\WaterManagement\Device\Sensor\Sensor;
use App\Domain\WaterManagement\Sensor\Consumption\WaterConsumption;
use App\Http\Data\Jobs\CheckPoint\ReportToDGA;
use App\Http\Data\Water\BackupWaterYear;
use App\Http\WaterManagement\Dashboard\Alarm\Traits\HasAuditTrait;
use Carbon\Carbon;
use Sentinel;
use SoapHeader;


class TestController extends SoapController
{
    use HasAnalogousData;

    public function __invoke()
    {
        ReportToDGA::dispatch(1);
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
            return collect(['tx-nivel'])->contains($sensor->type->slug);
        })->first();
    }

    protected function getToteSensor($sensors)
    {
        return $sensors->filter(function($sensor) {
            return collect([
                'totalizador-dga-arkon-modbus',
                'totalizador-dga-siemens-modbus',
                'totalizador-dga-wellford-modbus',
                'totalizador-dga-wellford-pulsos'
            ])->contains($sensor->type->slug);
        })->first();

    }

    protected function getFlowSensor($sensors)
    {
        return $sensors->filter(function($sensor) {
            return collect([
                'caudal-dga-arkon-modbus',
                'caudal-dga-siemens-modbus',
                'caudal-dga-wellford-corriente',
                'caudal-dga-wellford-modbus'
            ])->contains($sensor->type->slug);
        })->first();

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
