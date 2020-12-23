<?php

namespace App\Domain\WaterManagement\Device\Sensor\Behavior;

use App\App\Traits\Dates\HasDateScopes;
use App\Domain\WaterManagement\Device\Sensor\Sensor;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class SensorBehavior extends Model implements Auditable
{
    use HasDateScopes, \OwenIt\Auditing\Auditable;

    public $timestamps = false;

    protected $fillable = [
        'sensor_id',
        'static_level',
        'dynamic_level',
        'current_average',
        'date'
    ];

    public function sensor()
    {
        return $this->belongsTo(Sensor::class,'sensor_id','id');
    }
}
