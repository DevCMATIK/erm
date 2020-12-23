<?php

namespace App\Domain\WaterManagement\Device\Sensor\Disposition\Line;

use App\Domain\WaterManagement\Device\Sensor\Disposition\SensorDisposition;
use Illuminate\Database\Eloquent\Model;

class DispositionLine extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'sensor_disposition_id',
        'chart',
        'value',
        'color',
        'text'
    ];

    public function disposition()
    {
        return $this->belongsTo(SensorDisposition::class,'sensor_disposition_id','id');
    }
}
