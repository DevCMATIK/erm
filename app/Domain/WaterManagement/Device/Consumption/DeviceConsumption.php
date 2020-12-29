<?php

namespace App\Domain\WaterManagement\Device\Consumption;

use App\App\Traits\Dates\HasDateScopes;
use App\Domain\Client\CheckPoint\CheckPoint;
use App\Domain\WaterManagement\Device\Device;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class DeviceConsumption extends Model implements Auditable
{
    use HasDateScopes, \OwenIt\Auditing\Auditable;

    public $timestamps = false;

    protected $fillable = [
        'check_point_id',
        'active_energy',
        'water_input',
        'hour_value',
        'hour_consumption',
        'date'
    ];

    public function check_point()
    {
        return $this->belongsTo(CheckPoint::class,'check_point_id','id');
    }
}
