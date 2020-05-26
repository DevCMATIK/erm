<?php

namespace App\Domain\WaterManagement\Device\Sensor\Trigger;

use Illuminate\Database\Eloquent\Model;

class SensorTriggerLog extends Model
{
    public $timestamps = false;

    protected $fillable = ['sensor_trigger_id','last_execution','value_readed','command_executed'];

    public function trigger()
    {
        return $this->belongsTo(SensorTrigger::class,'sensor_trigger_id','id');
    }
}
