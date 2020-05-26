<?php

namespace App\Domain\WaterManagement\Device\Log;

use App\App\Traits\Dates\HasDateScopes;
use App\Domain\WaterManagement\Device\Device;
use Illuminate\Database\Eloquent\Model;

class DeviceOfflineLog extends Model
{
    use HasDateScopes;

    public $timestamps = false;

    protected $fillable = [
        'device_id',
        'start_date',
        'end_date',
        'notified'
    ];

    public function device()
    {
        return $this->belongsTo(Device::class,'device_id','id');
    }

    public function scopeNotifiable($query)
    {
        return $query->whereNull('end_date');
    }
}
