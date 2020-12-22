<?php

namespace App\Http\WaterManagement\Device\Sensor\Alarm\Controllers;

use App\Domain\System\Mail\Mail;
use App\Domain\WaterManagement\Device\Sensor\Alarm\AlarmNotification;
use App\Domain\WaterManagement\Device\Sensor\Alarm\SensorAlarm;
use App\Domain\WaterManagement\Device\Sensor\Sensor;
use App\Domain\WaterManagement\Group\Group;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;
use Sentinel;

class SensorAlarmController extends Controller
{
    public function index(Request $request)
    {
        $sensor = Sensor::find($request->sensor_id);

        return view('water-management.device.sensor.alarm.index',compact('sensor'));
    }

    public function create(Request $request)
    {
        $groups = Group::get();
        $mails = Mail::doesntHave('mail_reports')->where('share_with_all',1)->orWhere('user_id',Sentinel::getUser()->id)->get();
        $sensor = Sensor::find($request->sensor_id);
        return view('water-management.device.sensor.alarm.create',compact('sensor','mails','groups'));
    }

    public function store(Request $request)
    {
        if($record = SensorAlarm::create([
            'user_id' => Sentinel::getUser()->id,
            'sensor_id' => $request->sensor_id,
            'range_min' => $request->range_min,
            'range_max' => $request->range_max,
            'is_active' => ($request->has('is_active'))?1:0,
            'send_email' => ($request->has('send_email'))?1:0
        ])) {
            if($request->has('group_id')) {
                $i=0;
                for($i = 0;$i<count($request->group_id);$i++) {
                    $mail = "{$request->group_id[$i]}_mail_id";
                    $reminder = "{$request->group_id[$i]}_reminder_id";
                    $record->notifications()->create([
                        'group_id' => $request->group_id[$i],
                        'mail_id' => (isset($request->{$mail}) && $request->{$mail} != '')? $request->{$mail}: null,
                        'reminder_id' => (isset($request->{$reminder}) && $request->{$reminder} != '')? $request->{$reminder}: null
                    ]);
                }
            }
            return $this->getResponse('success.store');
        } else {
            return $this->getResponse('error.store');
        }
    }

    public function edit($id)
    {
        $groups = Group::get();
        $mails = Mail::where('share_with_all',1)->orWhere('user_id',Sentinel::getUser()->id)->get();
        $alarm = SensorAlarm::with(['notifications','sensor'])->find($id);
        $sensor = $alarm->sensor;
        return view('water-management.device.sensor.alarm.edit',compact('sensor','mails','groups','alarm'));
    }

    public function update(Request $request, $id)
    {
        $record = SensorAlarm::findOrFail($id);
        if($record->update([
            'range_min' => $request->range_min,
            'range_max' => $request->range_max,
            'is_active' => ($request->has('is_active'))?1:0,
            'send_email' => ($request->has('send_email'))?1:0
        ])) {
            $record->notifications()->delete();
            if($request->has('group_id')) {
                $i=0;
                for($i = 0;$i<count($request->group_id);$i++) {
                    $mail = "{$request->group_id[$i]}_mail_id";
                    $reminder = "{$request->group_id[$i]}_reminder_id";
                    $record->notifications()->create([
                        'group_id' => $request->group_id[$i],
                        'mail_id' => (isset($request->{$mail}) && $request->{$mail} != '')? $request->{$mail}: null,
                        'reminder_id' => (isset($request->{$reminder}) && $request->{$reminder} != '')? $request->{$reminder}: null
                    ]);
                }
            }
            return $this->getResponse('success.update');
        } else {
            return $this->getResponse('error.update');
        }
    }

    public function destroy($id)
    {
        if (SensorAlarm::destroy($id)) {
            return $this->getResponse('success.destroy');
        } else {
            return $this->getResponse('error.destroy');
        }
    }
}
