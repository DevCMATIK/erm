<?php

namespace App\Http\WaterManagement\Report\Traits;

use App\Domain\System\Mail\MailLog;
use App\Domain\WaterManagement\Main\Report;
use App\Mail\SystemMail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail as LaravelMailer;

trait SendMailReportTrait
{
    public function handleReportEmail($reportMail)
    {
        $sensor_list = $this->getTable($this->getValuesArray($reportMail));
        $users = $this->getUsersArray($reportMail);
        try {
            LaravelMailer::to(['sys-erm@cmatik.app']])
                ->bcc($users)
                ->send(new SystemMail(
                    $reportMail->mail,
                    Carbon::now()->toDateString(),
                    '',
                    false,
                    false,
                    false,
                    false,
                    false,
                    false,
                    false,
                    false,
                    $sensor_list,
                    Carbon::now()->toDateTimeString(),
                    Carbon::now()->toTimeString(),
                    false
                ));
            $log = MailLog::create([
                'mail_id' => $reportMail->mail->id,
                'mail_name' => $reportMail->mail->name,
                'identifier' => 'report-email',
                'date' => Carbon::now()->toDateTimeString(),
            ]);
        } catch(\Exception $e) {
            $log = MailLog::create([
                'mail_id' => $reportMail->mail->id,
                'mail_name' => $reportMail->mail->name,
                'identifier' => 'report-email-failed',
                'date' => Carbon::now()->toDateTimeString(),
            ]);
        }


        $reportMail->last_execution = Carbon::now();
        $reportMail->save();
    }

    protected function getUsersArray($reportMail)
    {
        $emails = array();
        foreach($reportMail->groups as $group){
            foreach($group->users as $user) {
                array_push($emails,$user->email);
            }
        }

        return $emails;
    }

    protected function getTable($sensors_list)
    {
        $html = '<table width="100%"  cellspacing="0" class="table table-striped"  style="margin: auto; text-align: left; border: none;" >';
        $html = $html . '<thead>
                            <tr>
                                <th width="30%">ZONA</th>
                                <th width="30%">SECTOR</th>
                                <th width="20%">VARIABLE</th>
                                <th width="20%">VALOR</th>
                            </tr>                
                        </thead>';
        $html = $html . '<tbody>';
        foreach(collect($sensors_list)->sortBy('position') as $sensor) {
            $html = $html . '<tr>
                                <td width="30%">'.$sensor['sub_zone'].'</td>
                                <td width="30%">'.$sensor['check_point'].'</td>
                                <td width="20%">'.$sensor['sensor'].'</td>
                                <td width="20%">'.$sensor['value'].'</td>
                            </tr>';
        }
        $html = $html . '</tbody>';
        return $html . '</table>';
    }

    protected function getValuesArray($reportMail)
    {
        $sensors_list = array();
        foreach($reportMail->sensors as $sensor){
            if($sensor->address->configuration_type == 'scale' ){
                $value = $this->getAnalogousValue($sensor);
            } else {
                $value = $this->getValue($sensor);
            }
            array_push($sensors_list,[
                'sensor' => $sensor->name,
                'device' => $sensor->device->name,
                'check_point' => $sensor->device->check_point->name,
                'sub_zone' => $sensor->device->check_point->sub_zones()->first()->name,
                'value' => $value,
                'position' => $sensor->getOriginal('pivot_position'),
            ]);
        }

        return $sensors_list;
    }

    protected function getValue($alarm)
    {
        $sensor_address = $alarm->sensor->full_address;
        $sensor_grd_id = $alarm->sensor->device->internal_id;

        return Report::where('grd_id',$sensor_grd_id)->first()->$sensor_address;
    }

    protected function getAnalogousValue($sensor)
    {
        $sensor_address = $sensor->full_address;
        $sensor_grd_id = $sensor->device->internal_id;
        $data = 'N/A';
        $unit = '';
        if (!$disposition = $sensor->selected_disposition()->first()) {
            $disposition = $sensor->dispositions()->first();
        }
        if($disposition) {
            $unit = $disposition->unit->name;
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
        if(is_numeric($data)){
            $data = number_format($data,1);
        }
        return $data.' '.$unit;
    }
}
