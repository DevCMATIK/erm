<?php

namespace App\Http\WaterManagement\Dashboard\Kpi;

use App\App\Traits\Scopes\Alarms\HasSearchScopes;
use App\App\Traits\Dates\DateUtilitiesTrait;
use App\Http\WaterManagement\Dashboard\Alarm\Traits\HasAlarmTrait;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;
use Sentinel;


class KpiAlarmsOnController extends Controller
{
    use HasAlarmTrait, DateUtilitiesTrait;

    public function __invoke(Request $request)
    {
        $queryString = explode('?',$request->fullUrl())[1]??false;
        if ($queryString != false)
        {
            return $this->getActiveAlarmsWithParameters($request)->get()->unique('log_id')->count()
                .'/'
                .$this->activeAlarmQuery()->get()->unique('log_id')->count();
        }else
        {
            return $this->activeAlarmQuery()->get()->unique('log_id')->count();
        }
    }
}
