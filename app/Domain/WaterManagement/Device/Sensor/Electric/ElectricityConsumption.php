<?php

namespace App\Domain\WaterManagement\Device\Sensor\Electric;

use App\App\Traits\Dates\HasDateScopes;
use App\Domain\Client\Zone\Sub\SubZone;
use App\Domain\WaterManagement\Device\Sensor\Sensor;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ElectricityConsumption extends Model implements Auditable
{
    use HasDateScopes, \OwenIt\Auditing\Auditable;

    public $timestamps = false;

    protected $fillable = [
        'sensor_id',
        'consumption',
        'first_read',
        'last_read',
        'high_consumption',
        'sub_zone_id',
        'sensor_type',
        'date'
    ];

    public function sensor()
    {
        return $this->belongsTo(Sensor::class,'sensor_id','id');
    }

    public function sub_zone()
    {
        return $this->belongsTo(SubZone::class,'sub_zone_id','id');
    }
}
