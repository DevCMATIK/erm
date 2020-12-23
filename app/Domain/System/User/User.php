<?php

namespace App\Domain\System\User;

use App\App\Traits\Permissions\Permissible;
use App\App\Traits\Roles\RoleableEntity;
use App\Domain\Client\ProductionArea\ProductionArea;
use App\Domain\Client\Zone\Sub\SubZone;
use App\Domain\Data\Export\ExportReminder;
use App\Domain\Device\Sensor\Alarm\UnaccusedAlarmLog;
use App\Domain\System\ChangeLog\ChangeLog;
use App\Domain\System\Role\Role;
use App\Domain\WaterManagement\Device\Sensor\Alarm\AlarmNotification;
use App\Domain\WaterManagement\Device\Sensor\Alarm\SensorAlarm;
use App\Domain\WaterManagement\Device\Sensor\Alarm\SensorAlarmLog;
use App\Domain\WaterManagement\Device\Sensor\Trigger\SensorTrigger;
use App\Domain\WaterManagement\Group\Group;
use App\Domain\WaterManagement\Report\MailReport;
use Cartalyst\Sentinel\Users\EloquentUser;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class User extends EloquentUser
{
    use RoleableEntity, Permissible, SoftDeletes, Notifiable;

    protected $dates = ['deleted_at','created_at','updated_at'];


    public function destroyRelationships()
    {
        if(!optional($this->roles)->first() || $this->roles()->detach()) {

            if(!optional($this->groups)->first() || $this->groups()->detach()) {
                if(!optional($this->sub_zones)->first() || $this->sub_zones()->detach()) {
                    if(!optional($this->production_areas)->first() || $this->production_areas()->detach()) {
                        return true;
                    }
                }

            }
        }
        return false;
    }

    public function getFullNameAttribute()
    {
        return $this->first_name." ".$this->last_name;
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class,'role_users','user_id','role_id');
    }


    public function groups()
    {
        return $this->belongsToMany(Group::class,'user_groups','user_id','group_id');
    }

    public function sensor_triggers()
    {
        return $this->hasMany(SensorTrigger::class,'user_id','id');
    }

    public function production_areas()
    {
        return $this->belongsToMany(ProductionArea::class,'user_production_areas','user_id','production_area_id');
    }

    public function sub_zones()
    {
        return $this->belongsToMany(SubZone::class,'user_sub_zones','user_id','sub_zone_id');
    }

    public function inProductionArea($productionArea)
    {
        foreach ($this->production_areas()->get() as $pa) {
            if($pa->id == $productionArea) {
                return true;
            }
        }
        return false;
    }

    public function inSubZone($subZone)
    {
        $user_sub_zones = $this->sub_zones()->pluck('id')->toArray();
        if(in_array($subZone,$user_sub_zones)) {
            return true;
        }

        return false;
    }

    public function getSubzonesIds()
    {
        return $this->sub_zones()->pluck('id')->toArray();
    }

    public function inGroup($group)
    {
        foreach ($this->groups()->get() as $g) {
            if($g->slug == $group) {
                return true;
            }
        }
        return false;
    }

    public function alarms_created()
    {
        return $this->hasMany(SensorAlarm::class,'user_id','id');
    }

    public function alarms_accused()
    {
        return $this->hasMany(SensorAlarmLog::class,'accused_by','id');
    }

    public function alarm_reminders()
    {
        return $this->belongsToMany(SensorAlarmLog::class,'users_notification_reminders','user_id','alarm_notification_id','id','id');
    }

    public function alarm_unaccused()
    {
        return $this->hasMany(UnaccusedAlarmLog::class,'user_id','id');
    }

    public function mail_report()
    {
        return $this->hasMany(MailReport::class,'user_id','id');
    }

    public function change_logs()
    {
        return $this->hasMany(ChangeLog::class,'user_id','id');
    }

    public function export_reminders()
    {
        return $this->hasMany(ExportReminder::class,'user_id','id');
    }
}
