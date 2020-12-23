<?php

namespace App\Domain\Client\Zone\Sub;

use App\App\Traits\Model\Sluggable;
use App\Domain\Client\CheckPoint\CheckPoint;
use App\Domain\Client\Zone\Zone;
use App\Domain\System\User\User;
use App\Domain\WaterManagement\Device\Sensor\Electric\ElectricityConsumption;
use App\Domain\WaterManagement\Group\Group;
use Illuminate\Database\Eloquent\Model;

class SubZone extends Model
{
    use Sluggable;

    public $timestamps = false;

    protected $fillable = [
        'zone_id','slug','name'
    ];

    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }

    public function check_points()
    {
        return $this->belongsToMany(CheckPoint::class,'check_point_sub_zones','sub_zone_id','check_point_id');
    }

    public function configuration()
    {
        return $this->hasOne(SubZoneConfiguration::class,'sub_zone_id','id');
    }

    public function elements()
    {
        return $this->hasMany(SubZoneElement::class,'sub_zone_id','id');

    }

    public function sub_elements()
    {
        return $this->hasManyThrough(SubZoneSubElement::class,SubZoneElement::class,'sub_zone_id','sub_zone_element_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class,'user_sub_zones','sub_zone_id','user_id');
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class,'group_sub_zones','sub_zone_id','group_id');
    }

    public function consumptions()
    {
        return $this->hasMany(ElectricityConsumption::class,'sub_zone_id','id');
    }

    public function energy_cost()
    {
        return $this->hasOne(SubZoneHourValue::class,'sub_zone_id','id');
    }
}
