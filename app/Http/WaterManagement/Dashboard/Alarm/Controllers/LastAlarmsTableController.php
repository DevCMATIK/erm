<?php

namespace App\Http\WaterManagement\Dashboard\Alarm\Controllers;

use App\Domain\Client\Zone\Sub\SubZone;
use App\Http\WaterManagement\Dashboard\Alarm\Traits\HasAlarmTrait;
use App\App\Traits\Dates\DateUtilitiesTrait;
use App\App\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;
use Datatables;
use Charts;
use PhpParser\Node\Expr\Array_;

class LastAlarmsTableController extends Controller
{
    use HasAlarmTrait,DateUtilitiesTrait;

    public function index(Request $request)
    {
       $alarm_logs=$this->getLastAlarmsWithParameters($request)->get();
       return view('water-management.dashboard.alarm.last-alarms',compact('alarm_logs'));

    }

    public function getSubZones(Request $request)
    {
        if ($request->ajax()){
            $subzones=SubZone::whereIn('zone_id', $request->zone_id)->get();
            foreach ($subzones as $subzone){
                $subZoneArray[$subzone->id]= $subzone->name;
            }
            return response() ->json($subZoneArray);
        }
    }
}
