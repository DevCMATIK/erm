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
use Illuminate\Support\Facades\DB;
use Sentinel;
use SoapHeader;
use Redis;


class TestController extends SoapController
{
    use HasAnalogousData;

    public function __invoke()
    {
        $devices =  Device::with('report','last_dc')->where('from_bio',0)
            ->get()->filter(function($device){
                return  optional($device->report)->state  === 0 ||
                (optional($device->last_dc)->start_date != '' && optional($device->last_dc)->end_date == null);
        });

        dd($devices->toArray());

        foreach($devices as  $device) {
            $state = optional($device->report)->state;

            if (optional($device->last_dc)->start_date != '' && optional($device->last_dc)->end_date == null) {
                if ($state === 0) {
                    continue;
                } else {
                    $last = $device->last_dc;
                    $last->end_date = Carbon::now()->toDateTimeString();
                    $last->save();
                }
            } else {
                if ($state === 0) {
                    $device->disconnections()->create([
                        'start_date' => Carbon::now()->toDateTimeString()
                    ]);
                }
            }
        }
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
