<?php

namespace App\Domain\WaterManagement\Device\Sensor\Range;

use App\Domain\WaterManagement\Device\Sensor\Sensor;
use Illuminate\Database\Eloquent\Model;

class SensorRange extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'sensor_id',
        'min',
        'max',
        'color'
    ];

    public function sensor()
    {
        return $this->belongsTo(Sensor::class,'sensor_id','id');
    }
}
