<?php

namespace App\Domain\WaterManagement\Report;

use App\Domain\System\Mail\Mail;
use App\Domain\System\User\User;
use App\Domain\WaterManagement\Device\Sensor\Sensor;
use App\Domain\WaterManagement\Group\Group;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MailReport extends Model
{
    use SoftDeletes;

    public $timestamps =false;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'mail_id',
        'user_id',
        'name',
        'frequency',
        'start_at',
        'is_active',
        'last_execution'
    ];

    public function mail()
    {
        return $this->belongsTo(Mail::class,'mail_id','id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class,'mail_report_groups','mail_report_id','group_id');
    }

    public function sensors()
    {
        return $this->belongsToMany(Sensor::class,'mail_report_sensors','mail_report_id','sensor_id')
            ->withPivot('position')
            ->enabled();
    }

    public function scopeActive($query) {
        return $query->where('is_active',1);
    }

    public function deleteReport()
    {
        $this->sensors()->detach();
        $this->groups()->detach();
        $this->delete();
    }

    public function generateCron()
    {
        $cron = '';
        switch($this->frequency) {
            default:
                $cron = "0 * * * *";
            break;
            case 'hourlyAt':
                if($this->start_at > 59) {
                    $minutes = 59;
                } elseif ($this->start_at < 0 ) {
                    $minutes = 0;
                } else {
                    $minutes = $this->start_at;
                }
                $cron = "{$minutes} * * * *";
                break;
            case 'dailyAt':
                if ($this->start_at > 23 || $this->start_at < 0 && is_numeric($this->start_at)) {
                    $hour = 0;
                } else {
                    $hour = $this->start_at;
                }

                $cron = "0 {$hour} * * *";
                break;
            case 'weeklyOn':
                $time = explode(',',$this->start_at);
                if($time[0] < 0 || $time[0] > 6) {
                    $day = 0;
                } else {
                    $day = $time[0];
                }
                if ($time[1] > 23 || $time[1]) {
                    $hour = 0;
                } else {
                    $hour = $time[0];
                }
                $cron = "0 {$hour} * * {$day}";
                break;
            case 'monthlyOn':
                $time = explode(',',$this->start_at);
                if($time[0] < 1) {
                    $day = 1;
                } elseif ($time[0] > 30) {
                    $day = 30;
                }
                else {
                    $day = $time[0];
                }
                if ($time[1] > 23 || $time[1]) {
                    $hour = 0;
                } else {
                    $hour = $time[0];
                }
                $cron = "0 {$hour} {$day} * *";
                break;
        }
        return $cron;
    }
}
