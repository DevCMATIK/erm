<?php

namespace App\Domain\WaterManagement\Group;

use App\App\Traits\Model\Sluggable;
use App\Domain\Client\Zone\Sub\SubZone;
use App\Domain\System\User\User;
use App\Domain\WaterManagement\Device\Sensor\Alarm\AlarmNotification;
use App\Domain\WaterManagement\Device\Sensor\Alarm\SensorAlarm;
use App\Domain\WaterManagement\Report\MailReport;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use Sluggable;

    public $timestamps = false;

    protected $fillable = ['slug','name'];

    public function users()
    {
        return $this->belongsToMany(User::class,'user_groups','group_id','user_id');
    }

    public function sub_zones()
    {
        return $this->belongsToMany(SubZone::class,'group_sub_zones','group_id','sub_zone_id');
    }

    public function inSubZone($subZone)
    {
        foreach ($this->sub_zones()->get() as $sub_zone) {
            if($sub_zone->id == $subZone) {
                return true;
            }
        }
        return false;
    }


    public function alarms()
    {
        return $this->belongsToMany(SensorAlarm::class,'alarm_groups','group_id','sensor_alarm_id');
    }

    public function notifications()
    {
        return $this->hasMany(AlarmNotification::class,'group_id','id');
    }

    public function mail_reports()
    {
        return $this->belongsToMany(MailReport::class,'mail_report_groups','group_id','mail_report_id');
    }
}
