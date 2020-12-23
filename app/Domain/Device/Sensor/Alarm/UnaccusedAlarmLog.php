<?php

namespace App\Domain\Device\Sensor\Alarm;

use App\Domain\System\User\User;
use App\Domain\WaterManagement\Device\Sensor\Alarm\SensorAlarmLog;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class UnaccusedAlarmLog extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    public $timestamps = false;

    protected $fillable = [
        'sensor_alarm_log_id',
        'user_id',
        'date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function log()
    {
        return $this->belongsTo(SensorAlarmLog::class,'sensor_alarm_log_id','id');
    }
}
