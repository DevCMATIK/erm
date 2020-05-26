<?php

namespace App\Http\WaterManagement\Device\Sensor\Alarm\Traits;

use App\Domain\System\Mail\MailLog;
use App\Domain\WaterManagement\Main\Report;
use App\Mail\SystemMail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail as LaravelMailer;

trait CheckAlarmsTrait
{
    public $min_or_max;

    public function handleAlarms($alarms)
    {
        foreach($alarms as $alarm)
        {
            if($alarm->sensor->has_alarm === 1) {
                if($alarm->sensor->address->configuration_type == 'scale' ){
                    $value = $this->getAnalogousValue($alarm);

                    $is_alarm = $this->handleAnalogousAlarm($alarm,$value);

                } else {
                    $value = $this->getValue($alarm);

                    $is_alarm = $this->handleDigitalAlarm($alarm,$value);
                }
                $this->handleAlarm($alarm,$value,$is_alarm);
            }
        }
    }

    protected function handleAlarm($alarm,$value,$is_alarm)
    {
        if ($is_alarm) {
            $this->handleAlarmActive($alarm,$value);
        } else {
            $this->handleAlarmEnding($alarm,$value);
        }
    }

    protected function handleAlarmActive($alarm,$value)
    {
        if(!$alarm->last_log()->first() || $alarm->last_log()->first()->end_date != null) {
            $last_log = $alarm->logs()->create([
                'start_date' => Carbon::now()->toDateTimeString(),
                'last_update' => Carbon::now()->toDateTimeString(),
                'first_value_readed' => $value,
                'last_value_readed' => $value,
                'min_or_max' => $this->min_or_max,
                'entries_counted' =>  1,
                'accused' => 0
            ]);
        } else {
            $last_log =$alarm->last_log->first();
            $counted = (int)optional($last_log)->entries_counted + 1;
            $last_log->update([
                'last_update' => Carbon::now()->toDateTimeString(),
                'last_value_readed' => $value,
                'min_or_max' => $this->min_or_max,
                'entries_counted' =>  $counted
            ]);
        }
        if($last_log->accused !== 1) {
            if(isset($alarm->last_log->first()->last_email)){
                if(Carbon::parse($alarm->last_log->first()->last_email)->diffInMinutes(Carbon::now()) >= 15) {
                    $this->handleEmails($alarm,$value);
                }
            } else {
                $this->handleEmails($alarm,$value);
            }

        }
    }

    protected function handleEmails($alarm,$value)
    {
        if($alarm->send_email === 1 && count($alarm->notifications) > 0) {
            switch($this->min_or_max) {
                case 1:
                    $type = 'Bajo';
                    break;
                case 2:
                    $type = 'Alto';
                    break;
                case 3:
                    $type = 'Digital';
                    break;
                default:
                    $type = '';
                    break;
            }
            foreach($alarm->notifications as $notification) {
                if($notification->mail_id != null) {
                    $users  = $notification->group->users->pluck('email')->toArray();
                        if($dis = $alarm->sensor->selected_disposition()->first()) {
                            $val = number_format($value,1).' '.$dis->unit->name;

                        } else {
                            if($dis = $alarm->sensor->dispositions->first()) {
                                    $val = number_format($value,1).' '.$dis->unit->name;
                            } else {
                                if($value === 1) {
                                    $val = $alarm->sensor->label->on_label;
                                } else {
                                    $val = $alarm->sensor->label->off_label;
                                }
                            }
                        }
                        LaravelMailer::to(['no-reply@cmatik.cl'])
                            ->bcc($users)
                            ->send(new SystemMail(
                                $notification->mail,
                                Carbon::now()->toDateString(),
                                '',
                                $alarm->sensor->name,
                                $alarm->sensor->device->check_point->name,
                                $alarm->sensor->device->name,
                                $alarm->sensor->device->check_point->sub_zones->first()->zone->name,
                                $alarm->sensor->device->check_point->sub_zones->first()->name,
                                $type,
                                $val,
                                Carbon::parse(optional($alarm->last_log()->first())->start_date)->toDateString(),
                                false,
                                Carbon::now()->toDateTimeString(),
                                Carbon::now()->toTimeString(),
                                Carbon::parse(optional($alarm->last_log()->first())->start_date)->toTimeString()
                            ));
                        $log = MailLog::create([
                            'mail_id' => $notification->mail->id,
                            'mail_name' => $notification->mail->name,
                            'identifier' => 'alarms-email',
                            'date' => Carbon::now()->toDateTimeString(),
                        ]);
                        foreach($notification->group->users->pluck('id')->toArray() as $user) {
                            $log->users()->create(['user_id' => $user]);
                        }

                }

            }
            $alarm->last_log()->first()->update(['last_email' => Carbon::now()->toDateTimeString()]);
            LaravelMailer::getSwiftMailer()->getTransport()->stop();
        }

    }


    protected function handleAlarmEnding($alarm,$value)
    {
        if($last_log = $alarm->last_log->first()) {
            if($last_log->end_date == null) {
                $last_log->end_date = Carbon::now()->toDateTimeString();
                $last_log->last_update = Carbon::now()->toDateTimeString();
                $last_log->last_value_readed = $value;
                $last_log->entries_counted = ($last_log->entries_counted != null)? (int)$last_log->entries_counted + 1: 1;
                $last_log->save();
            }
        }
    }

    protected function getValue($alarm)
    {
        $sensor_address = $alarm->sensor->full_address;
        $sensor_grd_id = $alarm->sensor->device->internal_id;

        return (int) Report::where('grd_id',$sensor_grd_id)->first()->{$sensor_address};
    }

    protected function getAnalogousValue($alarm)
    {
        $sensor_address = $alarm->sensor->full_address;
        $sensor_grd_id = $alarm->sensor->device->internal_id;
        if(!$disposition = $alarm->sensor->selected_disposition()->first()) {
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
        if(isset($data) && $data != '') {
            return $data;
        } else {
            return false;
        }

    }

    protected function handleDigitalAlarm($alarm,$value)
    {

        if((int) $value === (int) $alarm->range_min) {
            $this->min_or_max = 3;
            return true;
        }
        return false;
    }

    protected function handleAnalogousAlarm($alarm,$value)
    {

        if($alarm->range_max == null && (int)$value === (int) $alarm->range_min ) {

            $this->min_or_max = 3;
            return true;
        } else {
            if ($alarm->range_max !== null && $alarm->range_min !== null && $value >= $alarm->range_max) {
                $this->min_or_max = 2;

                return true;
            } else {
                if ($alarm->range_min !== null && $alarm->range_max && $value <= $alarm->range_min) {
                    $this->min_or_max = 1;
                    return true;
                }
            }
        }

        return false;
    }
}
