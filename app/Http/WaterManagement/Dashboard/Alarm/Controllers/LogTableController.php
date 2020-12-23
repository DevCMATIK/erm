<?php


namespace App\Http\WaterManagement\Dashboard\Alarm\Controllers;

use App\App\Controllers\Controller;
use App\App\Traits\Dates\DateUtilitiesTrait;
use App\Domain\Client\Zone\Sub\SubZone;
use App\Http\WaterManagement\Dashboard\Alarm\Traits\HasAlarmTrait;
use Illuminate\Http\Request;
use OwenIt\Auditing\Models\Audit;

class LogTableController extends Controller
{
    use HasAlarmTrait,DateUtilitiesTrait;

    public function index()
    {
        //$alarm_logs=$this->queryLog();

        //$alarm_logs = Audit::groupBy('modelname')->select('id')->get();
        //return view('water-management.audit.log')->withModels($models);
        $all_logs = Audit::all();

        //return view('mensajes.index')->with('mensajes',$mensajes);

        return view('water-management.audit.log',compact('all_logs'));

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
