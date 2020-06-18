<?php

namespace App\Domain\Client\CheckPoint\Indicator;

use App\Domain\Client\CheckPoint\CheckPoint;
use App\Domain\WaterManagement\Device\Sensor\Sensor;
use Illuminate\Database\Eloquent\Model;

class CheckPointIndicator extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'check_point_id',
        'sensor_id',
        'to_compare_sensor',
        'name',
        'type',
        'frame',
        'measurement',
        'group'
    ];

    public function check_point()
    {
        return $this->belongsTo(CheckPoint::class,'check_point_id','id');
    }

    public function sensor()
    {
        return $this->belongsTo(Sensor::class,'sensor_id','id');
    }

    public function sensor_to_compare()
    {
        return $this->belongsTo(Sensor::class,'to_compare_sensor','id');
    }

    public function getTypes()
    {
        return [
            'simple-rule-of-three',
            'count',
        ];
    }

    public function getFrames()
    {
        return [
            'last-hour',
            'today',
            'yesterday',
            'this-week',
            'last-week',
        ];
    }

    public function getMeasurements()
    {
        return [
            'seconds',
            'minutes',
            'hours'
        ];
    }
}
