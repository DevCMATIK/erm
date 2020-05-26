<?php

namespace App\Domain\WaterManagement\Log;

use App\Domain\System\User\User;
use App\Domain\WaterManagement\Device\Device;
use App\Domain\WaterManagement\Device\Sensor\Sensor;
use Illuminate\Database\Eloquent\Model;

class CommandLog extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'device_id',
        'sensor_id',
        'grd_id',
        'address',
        'order_executed',
        'execution_date',
        'ip_address'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function device()
    {
        return $this->belongsTo(Device::class,'device_id','id');
    }

    public function sensor()
    {
        return $this->belongsTo(Sensor::class,'sensor_id','id');
    }
}
