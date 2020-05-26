<?php

namespace App\Http\WaterManagement\Dashboard\Alarm\Controllers;

use App\Domain\Client\Zone\Zone;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;
use Sentinel;

class AlarmDashboardController extends Controller
{
    public function index() {
        $zones = Zone::whereHas('sub_zones', $filter =  function($query){
            $query->whereIn('id',Sentinel::getUser()->getSubZonesIds())->whereHas('configuration');
        })->with( ['sub_zones' => $filter])->get();
        return view('water-management.dashboard.alarm.index',compact('zones'));
    }
}
