<?php

namespace App\Domain\WaterManagement\Device\Address;

use App\App\Traits\Model\Sluggable;
use App\Domain\WaterManagement\Device\Sensor\Sensor;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use Sluggable;

    public $timestamps = false;

    protected $fillable = [
        'slug', 'name', 'configuration_type','register_type_id'
    ];

    public function sensors()
    {
        return $this->hasMany(Sensor::class,'address_id','id');
    }

    public function scopeAnalogous($query)
    {
        return $query->where('addresses.configuration_type','=','scale');
    }

    public function scopeDigital($query)
    {
        return $query->where('addresses.configuration_type','=','boolean');
    }

    public function scopeType($query,$type)
    {
        return $query->where('register_type_id','=',$type);
    }
}
