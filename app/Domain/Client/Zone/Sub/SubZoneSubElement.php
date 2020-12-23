<?php

namespace App\Domain\Client\Zone\Sub;

use App\Domain\Client\CheckPoint\CheckPoint;
use App\Domain\WaterManagement\Device\Device;
use Illuminate\Database\Eloquent\Model;

class SubZoneSubElement extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'sub_zone_element_id',
        'device_id',
        'check_point_id',
        'position',
    ];

    public function parent()
    {
        return $this->belongsTo(SubZoneElement::class,'sub_zone_element_id','id');
    }

    public function element()
    {
        return $this->belongsTo(SubZoneElement::class,'sub_zone_element_id','id');
    }

    public function device()
    {
        return $this->belongsTo(Device::class,'device_id','id');
    }

    public function check_point()
    {
        return $this->belongsTo(CheckPoint::class,'check_point_id','id');
    }

    public function sensors()
    {
        return $this->hasMany(SubElementSensor::class,'sub_element_id','id')->orderBy('sub_element_sensors.position');
    }
    public function digital_sensors()
    {
        return $this->sensors()->with('sensor.address')->digital();
    }

    public function analogous_sensors()
    {
        return $this->sensors()->analogous();
    }

    public function active_alarm()
    {
        return $this->check_point()->has('active_alarm');
    }

    public function active_and_accused_alarm()
    {
        return $this->check_point()->has('active_and_accused_alarm');
    }

    public function active_and_not_accused_alarm()
    {
        return $this->check_point()->has('active_and_not_accused_alarm');
    }

    public function has_devices_offline()
    {
        if($this->check_point()->has('devices_offline')) {
            return true;
        }

        return false;
    }

}
