<?php

namespace App\Domain\WaterManagement\Device\Sensor\Chronometer;

use App\Domain\WaterManagement\Device\Sensor\Sensor;
use Illuminate\Database\Eloquent\Model;

class SensorChronometer extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'sensor_id',
        'equals_to',
        'is_valid'
    ];

    public function sensor()
    {
        return $this->belongsTo(Sensor::class,'sensor_id','id');
    }

    public function trackings()
    {
        return $this->hasMany(ChronometerTracking::class,'chronometer_id','id');
    }

    public function last_tracking()
    {
        return $this->hasOne(ChronometerTracking::class,'chronometer_id','id')->orderBy('start_date','desc');
    }
}
