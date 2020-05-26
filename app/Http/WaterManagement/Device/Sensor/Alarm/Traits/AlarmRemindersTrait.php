<?php

namespace App\Http\WaterManagement\Device\Sensor\Alarm\Traits;

use App\Domain\System\Mail\MailLog;
use App\Domain\WaterManagement\Main\Report;
use App\Mail\SystemMail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail as LaravelMailer;

trait AlarmRemindersTrait
{

    public function handleAlarms($alarms)
    {
        foreach($alarms as $alarm)
        {
            if($alarm->sensor->address->configuration_type == 'scale' ){
                $value = $this->getAnalogousValue($alarm);

            } else {
                $value = $this->getValue($alarm);
            }
            $this->handleEmails($alarm,$value);
        }
    }


    protected function handleEmails($alarm,$value)
    {
        if( count($alarm->notifications) > 0) {

            foreach($alarm->notifications as $notification) {
                if($notification->reminder_id != null) {
                    foreach($alarm->last_log()->first()->user_reminders->unique('id') as $user) {

                            LaravelMailer::to($user->email)
                                ->send(new SystemMail(
                                    $notification->reminder,
                                    Carbon::now()->toDateString(),
                                    $user->full_name,
                                    $alarm->sensor->name,
                                    $alarm->sensor->device->check_point->name,
                                    $alarm->sensor->device->name,
                                    $alarm->sensor->device->check_point->sub_zones->first()->zone->name,
                                    $alarm->sensor->device->check_point->sub_zones->first()->name,
                                    false,
                                    number_format($value,1).  $alarm->sensor->dispositions()->where('id',$alarm->sensor->default_disposition)->first()->unit->name,
                                    false,
                                    false,
                                    Carbon::now()->toDateTimeString(),
                                    Carbon::now()->toTimeString(),
                                    false
                                ));
                        $log = MailLog::create([
                            'mail_id' => $notification->mail->id,
                            'mail_name' => $notification->mail->name,
                            'identifier' => 'alarm-reminder-email',
                            'date' => Carbon::now()->toDateTimeString(),
                        ]);

                        $log->users()->create(['user_id' => $user->id]);

                    }
                }

            }
        }
    }

    protected function getValue($alarm)
    {
        $sensor_address = $alarm->sensor->full_address;
        $sensor_grd_id = $alarm->sensor->device->internal_id;

        return Report::where('grd_id',$sensor_grd_id)->first()->$sensor_address;
    }

    protected function getAnalogousValue($alarm)
    {
        $sensor_address = $alarm->sensor->full_address;
        $sensor_grd_id = $alarm->sensor->device->internal_id;
        if(!$disposition = $alarm->sensor->selected_disposition->first())
        {
            $disposition = $alarm->sensor->dispositions()->first();
        }
        if($disposition) {
            $valorReport = Report::where('grd_id',$sensor_grd_id)->first()->$sensor_address;
            if($valorReport){
                $ingMin = $disposition->sensor_min;
                $ingMax = $disposition->sensor_max;
                $escalaMin = $disposition->scale_min;
                $escalaMax = $disposition->scale_max;
                if($escalaMin == null && $escalaMax == null) {
                    $data = ($ingMin * $valorReport) + $ingMax;
                } else {
                    $f1 = $ingMax - $ingMin;
                    $f2 = $escalaMax - $escalaMin;
                    $f3 = $valorReport - $escalaMin;
                    if($f2 == 0) {
                        $data = ((0)*($f3)) + $ingMin ;
                    } else {
                        $data = (($f1/$f2)*($f3)) + $ingMin ;
                    }
                }

            }
        }
        return $data;
    }

}
