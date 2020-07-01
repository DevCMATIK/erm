<?php

namespace App\Http\WaterManagement\Device\Sensor\Trigger\Traits;

use App\Domain\WaterManagement\Device\Sensor\Trigger\SensorTrigger;
use App\Domain\WaterManagement\Main\Command;
use App\Domain\WaterManagement\Main\Report;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Exception;

trait TriggersCommandTrait
{
    public function handleTriggers($triggers)
    {
        foreach($triggers as $trigger) {

            if($trigger->receptor) {
                $receptorValue = $this->getReceptorValue($trigger);
                if($trigger->sensor->address->configuration_type == 'scale' ){
                    $value = $this->getAnalogousValue($trigger);
                    $this->handleAnalogousCommand($trigger,$value,$receptorValue);
                } else {
                    $value = $this->getValue($trigger);
                    $this->handleDigitalCommand($trigger,$value,$receptorValue);
                }
            }


        }
    }

    protected function handleAnalogousCommand($trigger,$value,$receptorValue)
    {
        if ($trigger->range_max !== null && $value >= $trigger->range_max) {
            if($trigger->in_range != $receptorValue ) {
                $this->executeCommand(
                    $trigger->receptor->device->internal_id,
                    $trigger->receptor->address_number,
                    $trigger->in_range,
                    $trigger,
                    $value
                );
            }
        } else {
            if ($trigger->range_min !== null && $value <= $trigger->range_min) {
                $val = ($trigger->in_range === 1)?0:1;
                if($val != $receptorValue ) {
                    $this->executeCommand(
                        $trigger->receptor->device->internal_id,
                        $trigger->receptor->address_number,
                        $val,
                        $trigger,
                        $value
                    );
                }
            }
        }

    }

    protected function handleDigitalCommand($trigger,$value,$receptorValue)
    {

        if($value == 1) {
            if ($trigger->when_one != null) {
                if ($trigger->when_one != $receptorValue)
                {
                    $this->executeCommand(
                        $trigger->receptor->device->internal_id,
                        $trigger->receptor->address_number,
                        $trigger->when_one,
                        $trigger,
                        $value
                    );
                }
            }
        } else {
            if ($trigger->when_zero !== null) {
                if ($trigger->when_zero != $receptorValue) {
                    $this->executeCommand(
                        $trigger->receptor->device->internal_id,
                        $trigger->receptor->address_number,
                        $trigger->when_zero,
                        $trigger,
                        $value
                    );
                }
            }
        }

    }

    protected function getValue($trigger)
    {
        $sensor_address = $trigger->sensor->full_address;
        $sensor_grd_id = $trigger->sensor->device->internal_id;

        return Report::where('grd_id',$sensor_grd_id)->first()->$sensor_address;
    }

    protected function getAnalogousValue($trigger)
    {
        $sensor_address = $trigger->sensor->full_address;
        $sensor_grd_id = $trigger->sensor->device->internal_id;
        $disposition = $trigger->sensor->dispositions()->where('id',$trigger->sensor->default_disposition)->first();
        if(!$disposition) {
            $disposition = $trigger->sensor->dispositions()->first();
        }
        if($disposition) {
            $valorReport = Report::where('grd_id',$sensor_grd_id)->first()->$sensor_address;
            if($valorReport){
                $ingMin = $disposition->sensor_min;
                $ingMax = $disposition->sensor_max;
                $escalaMin = $disposition->scale_min;
                $escalaMax = $disposition->scale_max;
                if($escalaMin == null && $escalaMax == null) {
                    $data = ($ingMin * $valorReport) + $ingMax;
                } else {
                    $f1 = $ingMax - $ingMin;
                    $f2 = $escalaMax - $escalaMin;
                    $f3 = $valorReport - $escalaMin;
                    if($f2 == 0) {
                        $data = ((0)*($f3)) + $ingMin ;
                    } else {
                        $data = (($f1/$f2)*($f3)) + $ingMin ;
                    }
                }

            }
            if(isset($data)) {
                return $data;
            }
        }

        return false;


    }

    protected function getReceptorValue($trigger)
    {
        $sensor_address = $trigger->receptor->full_address;
        $sensor_grd_id = $trigger->receptor->device->internal_id;

        $report = Report::where('grd_id',$sensor_grd_id)->first();
        return  $report->$sensor_address;
    }

    protected function executeCommand($grd_id,$address,$order,$trigger,$value)
    {

        if($command = Command::create([
            'command_id' => null,
            'function' => 0,
            'grd_id' => $grd_id,
            'register_type' => 9,
            'output_number' => $address,
            'state' => $order,
            'date' => Carbon::now()->toDateTimeString()
        ])){
            $t = SensorTrigger::find($trigger->id);
            $t->logs()->create([
                'value_readed' => $value,
                'command_executed' => $order,
                'last_execution' => Carbon::now()->toDateTimeString()
            ]);

            $t->last_execution = Carbon::now()->toDateTimeString();
            $t->save();
        }else {
            throw new Exception('no insertado');
        }

    }

}
