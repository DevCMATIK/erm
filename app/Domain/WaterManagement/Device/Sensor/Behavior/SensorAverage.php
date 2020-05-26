<?php

namespace App\Domain\WaterManagement\Device\Sensor\Behavior;

use App\Domain\WaterManagement\Device\Sensor\Sensor;
use Illuminate\Database\Eloquent\Model;

class SensorAverage extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'sensor_id',
        'last_average',
        'pointer_date'
    ];

    public function sensor()
    {
        return $this->belongsTo(Sensor::class,'sensor_id','id');
    }
}
