<?php

namespace App\Domain\ERM;

use Illuminate\Database\Eloquent\Model;

class SensorAlarmLog extends Model
{
    protected $connection = 'erm';
    protected $table = 'watermanagement.sensor_alarm_logs';


    protected $fillable = [
        'sensor_alarm_id',
        'start_date',
        'end_date',
        'last_update',
        'first_value_readed',
        'last_value_readed',
        'accused',
        'accused_by',
        'accused_at',
        'last_email',
        'min_or_max',
        'entries_counted'

    ];
}
