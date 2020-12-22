<?php

namespace App\Domain\WaterManagement\Device\Type;

use App\App\Traits\Model\Sluggable;
use App\Domain\WaterManagement\Device\Device;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class DeviceType extends Model implements Auditable
{
    use Sluggable,\OwenIt\Auditing\Auditable;

    public $timestamps = false;

    protected $fillable = ['slug','name','model','brand'];

    public function devices()
    {
        return $this->hasMany(Device::class,'device_type_id','id');
    }
}
