<?php

namespace App\Domain\Production\AnalogousReport;

use App\App\Traits\Dates\HasDateScopes;
use App\Domain\Data\Analogous\AnalogousDispositionsReport;
use App\Domain\WaterManagement\Device\Device;
use App\Domain\WaterManagement\Device\Sensor\Sensor;
use App\Domain\WaterManagement\Historical\HistoricalType;
use Illuminate\Database\Eloquent\Model;
use Staudenmeir\EloquentEagerLimit\HasEagerLimit;

class AnalogousReport extends Model
{
    protected $connection= 'production';

    use HasDateScopes,HasEagerLimit;

    public $timestamps = false;

    protected $fillable = [
        'device_id',
        'register_type',
        'address',
        'sensor_id',
        'historical_type_id',
        'scale',
        'scale_min',
        'scale_max',
        'ing_min',
        'ing_max',
        'unit',
        'value',
        'result',
        'date',
        'scale_color',
        'interpreter',
        'pump_location'
    ];

    public function device()
    {
        return $this->belongsTo(Device::class,'device_id','id');
    }

    public function sensor()
    {
        return $this->belongsTo(Sensor::class,'sensor_id','id');
    }

    public function historical_type()
    {
        return $this->belongsTo(HistoricalType::class,'historical_type_id','id');
    }

    public function dispositions()
    {
        return $this->hasMany(AnalogousDispositionsReport::class,'analogous_report_id','id');
    }
}
