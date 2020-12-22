<?php

namespace App\Domain\WaterManagement\Device\Sensor\Alarm;

use App\Domain\System\Mail\Mail;
use App\Domain\System\User\User;
use App\Domain\WaterManagement\Group\Group;
use Cartalyst\Sentinel\Laravel\Facades\Reminder;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class AlarmNotification extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    public $timestamps = false;

    protected $fillable = [
        'alarm_id','group_id','mail_id','reminder_id'
    ];

    public function alarm()
    {
        return $this->belongsTo(SensorAlarm::class,'alarm_id','id');
    }

    public function group()
    {
        return $this->belongsTo(Group::class,'group_id','id');
    }

    public function mail()
    {
        return $this->belongsTo(Mail::class,'mail_id','id');
    }

    public function reminder()
    {
        return $this->belongsTo(Mail::class,'reminder_id','id');
    }


}
