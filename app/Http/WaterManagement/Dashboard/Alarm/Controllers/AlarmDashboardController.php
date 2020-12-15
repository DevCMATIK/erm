<?php

namespace App\Http\WaterManagement\Dashboard\Alarm\Controllers;

use App\Domain\Client\Zone\Sub\SubZone;
use App\Domain\Client\Zone\Zone;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;
use Sentinel;

class AlarmDashboardController extends Controller
{
    public function index(Request $request) {
        $queryString = explode('?',$request->fullUrl())[1]??false;
        $zones = Zone::whereHas('sub_zones', $filter =  function($query){
            $query->whereIn('id',Sentinel::getUser()->getSubZonesIds())->whereHas('configuration');
            })->with( ['sub_zones' => $filter])->get();
        if($request->has('sub_zones')) {
            $sub_zones = SubZone::whereIn('id',$request->sub_zones)->get();

        } else {
            $sub_zones = false;
        }
        return view('water-management.dashboard.alarm.index',compact('zones','queryString','request','sub_zones'));
    }
}
