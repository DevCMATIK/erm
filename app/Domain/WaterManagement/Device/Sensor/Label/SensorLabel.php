<?php

namespace App\Domain\WaterManagement\Device\Sensor\Label;

use App\Domain\WaterManagement\Device\Sensor\Sensor;
use Illuminate\Database\Eloquent\Model;

class SensorLabel extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name','sensor_id','on_label','off_label'
    ];

    public function sensor()
    {
        return $this->belongsTo(Sensor::class,'sensor_id','id');
    }
}
