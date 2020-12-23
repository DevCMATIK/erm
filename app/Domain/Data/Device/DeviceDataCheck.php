<?php

namespace App\Domain\Data\Device;

use App\Domain\WaterManagement\Device\Device;
use Illuminate\Database\Eloquent\Model;

class DeviceDataCheck extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'device_id','address','check','month','backup_start','backup_end'
    ];

    public function device()
    {
        return $this->belongsTo(Device::class,'device_id','id');
    }
}
