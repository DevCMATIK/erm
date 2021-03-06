<?php

namespace App\Domain\Backup;

use App\Domain\WaterManagement\Device\Device;
use App\Domain\WaterManagement\Device\Sensor\Sensor;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class SensorBackupCheck extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    public $timestamps = false;

    protected $fillable = [
        'device_id',
        'sensor_id',
        'start',
        'end',
        'entries'
    ];

    public function sensor()
    {
        return $this->belongsTo(Sensor::class,'sensor_id','id');
    }

    public function device()
    {
        return $this->belongsTo(Device::class,'device_id','id');
    }
}
