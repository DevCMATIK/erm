<?php

namespace App\Http\WaterManagement\Dashboard\Alarm\Controllers;

use App\App\Traits\Dates\DateUtilitiesTrait;
use App\Domain\System\User\User;
use App\Http\WaterManagement\Dashboard\Alarm\Traits\HasAlarmTrait;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;
use Sentinel;


class ActiveAlarmsTableController extends Controller
{
    use HasAlarmTrait,DateUtilitiesTrait;

    public function index(Request $request)
    {
        $alarm_logs=$this->getActiveAlarmsWithParameters($request)->get();
        return view('water-management.dashboard.alarm.active-table',compact('alarm_logs'));
    }

    public function remindMeAlarm(Request $request)
    {
        $val = explode('_',$request->element);
        User::find($val[2])->alarm_reminders()->toggle($val[1]);
    }


    public function getSearch(Request $request)
    {
        $val = explode('_',$request->element);
        User::find($val[2])->alarm_reminders()->toggle($val[1]);
    }
}
