<?php

namespace App\Domain\WaterManagement\Device\Sensor\Chronometer;

use Illuminate\Database\Eloquent\Model;

class ChronometerTracking extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'chronometer_id',
        'start_date',
        'end_date',
        'value'
    ];

    public function chronometer()
    {
      return $this->belongsTo(SensorChronometer::class,'chronometer_id','id');
    }
}
