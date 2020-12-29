<?php

namespace App\Domain\Client\CheckPoint\Indicator;

use App\Domain\Client\CheckPoint\CheckPoint;
use App\Domain\WaterManagement\Device\Sensor\Chronometer\SensorChronometer;
use App\Domain\WaterManagement\Device\Sensor\Sensor;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class CheckPointIndicator extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    public $timestamps = false;

    protected $fillable = [
        'check_point_id',
        'chronometer_id',
        'chronometer_to_compare',
        'name',
        'type',
        'color',
        'frame',
        'measurement',
        'group'
    ];

    public function check_point()
    {
        return $this->belongsTo(CheckPoint::class,'check_point_id','id');
    }

    public function chronometer()
    {
        return $this->belongsTo(SensorChronometer::class,'chronometer_id','id');
    }

    public function chronometer_to_compare()
    {
        return $this->belongsTo(SensorChronometer::class,'chronometer_to_compare','id');
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
