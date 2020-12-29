<?php

namespace App\Domain\WaterManagement\Device\Sensor\Alarm;


use App\App\Traits\Scopes\HasSearchScopes;
use App\App\Traits\Dates\HasDateScopes;
use App\Domain\Device\Sensor\Alarm\UnaccusedAlarmLog;
use App\Domain\System\User\User;
use Illuminate\Database\Eloquent\Model;

class SensorAlarmLog extends Model
{
    use HasDateScopes, HasSearchScopes;

    public $timestamps = false;

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

    public function accuser()
    {
        return $this->belongsTo(User::class,'accused_by','id');
    }

    public function sensor_alarm()
    {
        return $this->belongsTo(SensorAlarm::class,'sensor_alarm_id','id');
    }

    public function scopeActive($query)
    {
        return $query->whereNull('end_date');
    }

    public function scopeActiveAndAccused($query)
    {
        return $query->whereNotNull('accused_by')->whereNull('end_date');
    }

    public function scopeActiveAndNotAccused($query)
    {
        return $query->whereNull('accused_by')->whereNull('end_date');
    }

    public function scopeAccused($query)
    {
        return $query->whereNotNull('accused_by');
    }

    public function unaccused_alarms()
    {
        return $this->hasMany(UnaccusedAlarmLog::class,'sensor_alarm_log_id','id');
    }

    public function user_reminders()
    {
        return $this->belongsToMany(User::class,'users_notification_reminders','alarm_notification_id','user_id','id');
    }
}
