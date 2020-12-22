<?php

namespace App\Domain\WaterManagement\Device\Sensor\Alarm;

use App\Domain\System\User\User;
use App\Domain\WaterManagement\Device\Sensor\Sensor;
use App\Domain\WaterManagement\Group\Group;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class SensorAlarm extends Model implements Auditable
{
    use SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $dates = ['deleted_at'];

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'sensor_id',
        'range_min',
        'range_max',
        'is_active',
        'send_email'
    ];

    public function sensor()
    {
        return $this->belongsTo(Sensor::class,'sensor_id','id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function logs()
    {
        return $this->hasMany(SensorAlarmLog::class,'sensor_alarm_id','id');
    }

    public function last_log()
    {
        return $this->logs()->orderBy('id','desc');
    }

    public function active_alarm()
    {
        return $this->last_log()->active();
    }

    public function active_and_accused_alarm()
    {
        return $this->last_log()->activeAndAccused();
    }

    public function active_and_not_accused_alarm()
    {
        return $this->last_log()->activeAndNotAccused();
    }

    public function notifications()
    {
        return $this->hasMany(AlarmNotification::class,'alarm_id','id');
    }


}
