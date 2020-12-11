<?php

namespace App\Http\WaterManagement\Dashboard\Kpi;

use App\App\Traits\Dates\DateUtilitiesTrait;
use App\Domain\Client\Zone\Zone;
use App\Domain\WaterManagement\Device\Sensor\Alarm\SensorAlarmLog;
use App\Domain\WaterManagement\Main\Historical;
use App\Http\WaterManagement\Dashboard\Alarm\Traits\HasAlarmTrait;

use App\Http\WaterManagement\Device\Sensor\Alarm\Controllers\AlarmLogController;
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
