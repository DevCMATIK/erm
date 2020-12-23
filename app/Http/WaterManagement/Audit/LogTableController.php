<?php


namespace App\Http\WaterManagement\Audit;


use App\App\Controllers\Controller;
use App\App\Traits\Dates\DateUtilitiesTrait;
use App\Domain\Client\Zone\Sub\SubZone;
use App\Http\WaterManagement\Dashboard\Alarm\Traits\HasAlarmTrait;
use Illuminate\Http\Request;

class LogTableController extends Controller
{
    use HasAlarmTrait,DateUtilitiesTrait;

    public function index(Request $request)
    {
        $alarm_logs=Audit::class;
        return view('water-management.audit.log',compact('alarm_logs'));

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
