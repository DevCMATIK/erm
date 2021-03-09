<?php

namespace App\Domain\ERM;

use Illuminate\Database\Eloquent\Model;

class SensorTriggerLog extends Model
{
    protected $connection = 'erm';
    protected $table = 'watermanagement.sensor_trigger_logs';
    protected $fillable = ['sensor_trigger_id','last_execution','value_readed','command_executed'];
}
