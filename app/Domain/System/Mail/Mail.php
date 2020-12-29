<?php

namespace App\Domain\System\Mail;

use App\Domain\System\User\User;
use App\Domain\WaterManagement\Device\Sensor\Alarm\AlarmNotification;
use App\Domain\WaterManagement\Report\MailReport;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Mail extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'name',
        'subject',
        'body',
        'header',
        'share_with_all',
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function attachables()
    {
        return $this->belongsToMany(MailAttachable::class,'mail_attached_values','mail_id','mail_attachable_id');
    }

    public function notifications()
    {
        return $this->hasMany(AlarmNotification::class,'mail_id','id');
    }

    public function reminders()
    {
        return $this->hasMany(AlarmNotification::class,'reminder_id','id');
    }

    public function mail_reports()
    {
        return $this->hasMany(MailReport::class,'mail_id','id');
    }
}
