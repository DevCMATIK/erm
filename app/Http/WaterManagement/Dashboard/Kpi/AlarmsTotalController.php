<?php

namespace App\Http\WaterManagement\Dashboard\Kpi;

use App\App\Traits\Dates\DateUtilitiesTrait;
use App\Http\WaterManagement\Dashboard\Alarm\Traits\HasAlarmTrait;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;
use Sentinel;

class AlarmsTotalController extends Controller
{
    use HasAlarmTrait, DateUtilitiesTrait;

    public function __invoke(Request $request)
    {
        $queryString = explode('?',$request->fullUrl())[1]??false;
        if ($queryString != false){
            return $this->getLastAlarmsWithParameters($request)->count()
                .'/'
                .$this->lastAlarmQuery()->count();
        }else
        {
            return $this->lastAlarmQuery()->count();
        }

    }
}
