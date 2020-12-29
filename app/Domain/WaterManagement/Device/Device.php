<?php

namespace App\Domain\WaterManagement\Device;

use App\Domain\Client\CheckPoint\CheckPoint;
use App\Domain\Client\Zone\Sub\SubZone;
use App\Domain\Client\Zone\Sub\SubZoneSubElement;
use App\Domain\Data\Analogous\AnalogousReport;
use App\Domain\Data\Device\DeviceDataCheck;
use App\Domain\Data\Digital\DigitalReport;
use App\Domain\WaterManagement\Device\Consumption\DeviceConsumption;
use App\Domain\WaterManagement\Device\Log\DeviceOfflineLog;
use App\Domain\WaterManagement\Device\Sensor\Sensor;
use App\Domain\WaterManagement\Device\Type\DeviceType;
use App\Domain\WaterManagement\Main\Historical;
use App\Domain\WaterManagement\Main\Report;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Device extends Model implements Auditable
{
    use SoftDeletes, \OwenIt\Auditing\Auditable;

    public $timestamps = false;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'device_type_id',
        'check_point_id',
        'internal_id',
        'name',
        'from_bio'
    ];

    public function type()
    {
        return $this->belongsTo(DeviceType::class,'device_type_id','id');
    }

    public function check_point()
    {
        return $this->belongsTo(CheckPoint::class,'check_point_id','id');
    }


    public function sensors()
    {
        return $this->hasMany(Sensor::class,'device_id','id');
    }

    public function analogous_sensors()
    {
        return $this->hasMany(Sensor::class,'device_id','id')->analogous();
    }

    public function historical()
    {
        return $this->belongsTo(Historical::class,'internal_id','grd_id');
    }

    public function report()
    {
        return $this->belongsTo(Report::class,'internal_id','grd_id');
    }

    public function analogous_reports()
    {
        return  $this->hasMany(AnalogousReport::class,'device_id','id');
    }

    public function digital_reports()
    {
        return $this->hasMany(DigitalReport::class,'device_id','id');
    }

    public function data_checks()
    {
        return $this->hasMany(DeviceDataCheck::class,'device_id','id');
    }

    public function output_sensors()
    {
        return $this->sensors()->output();
    }

    public function active_alarm()
    {
        return $this->sensors()->has('active_alarm');
    }

    public function active_and_accused_alarm()
    {
        return $this->sensors()->has('active_and_accused_alarm');
    }

    public function active_and_not_accused_alarm()
    {
        return $this->sensors()->has('active_and_not_accused_alarm');
    }

    public function sub_element()
    {
        return $this->hasMany(SubZoneSubElement::class,'device_id','id');
    }

    public function is_offline()
    {
        return $this->report()->offline();
    }

    public function disconnections()
    {
        return $this->hasMany(DeviceOfflineLog::class,'device_id','id');
    }

    public function last_disconnection()
    {
        return $this->disconnections()->orderBy('id','desc');
    }

    public function scopeCheckPointType($query,$slug)
    {
        return $this->whereHas('check_point',function($q) use($slug){
            return $q->checkType($slug);
        });
    }
}
