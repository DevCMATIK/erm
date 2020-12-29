<?php

namespace App\Domain\WaterManagement\Device\Sensor\Trigger;

use App\Domain\System\User\User;
use App\Domain\WaterManagement\Device\Sensor\Sensor;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class SensorTrigger extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'sensor_id',
        'receptor_id',
        'when_one',
        'when_zero',
        'send_alert',
        'minutes',
        'range_min',
        'range_max',
        'in_range',
        'last_execution',
        'is_active'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function sensor()
    {
        return $this->belongsTo(Sensor::class,'sensor_id','id');
    }

    public function receptor()
    {
        return $this->belongsTo(Sensor::class,'receptor_id','id');
    }

    public function logs()
    {
        return $this->hasMany(SensorTriggerLog::class,'sensor_trigger_id','id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active',1);
    }

}
