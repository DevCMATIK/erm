<?php

namespace App\Domain\Data\Digital;

use App\App\Traits\Dates\HasDateScopes;
use App\Domain\WaterManagement\Device\Device;
use App\Domain\WaterManagement\Device\Sensor\Sensor;
use App\Domain\WaterManagement\Historical\HistoricalType;
use Illuminate\Database\Eloquent\Model;

class DigitalReport extends Model
{
    use HasDateScopes;

    public $timestamps = false;

    protected $fillable = [
        'device_id',
        'register_type',
        'address',
        'sensor_id',
        'historical_type_id',
        'name',
        'on_label',
        'off_label',
        'value',
        'label',
        'date',
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
