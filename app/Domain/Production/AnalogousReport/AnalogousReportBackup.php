<?php

namespace App\Domain\Production\AnalogousReport;

use App\App\Traits\Dates\HasDateScopes;
use App\Domain\Data\Analogous\AnalogousDispositionsReport;
use App\Domain\WaterManagement\Device\Device;
use App\Domain\WaterManagement\Device\Sensor\Sensor;
use App\Domain\WaterManagement\Historical\HistoricalType;
use Illuminate\Database\Eloquent\Model;
use Staudenmeir\EloquentEagerLimit\HasEagerLimit;

class AnalogousReportBackup extends Model
{
    use HasDateScopes;

    public $timestamps = false;

    protected $table = 'analogous_reports_backup';

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
        'interpreter'
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

}
