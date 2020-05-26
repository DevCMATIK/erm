<?php

namespace App\Http\Client\CheckPoint\Controllers;

use App\Domain\Client\CheckPoint\CheckPoint;
use App\Domain\Client\Zone\Sub\SubZone;
use App\App\Controllers\Controller;

class GetSubZonesController extends Controller
{
    public function getSubZones($zone_id,$check_point_id = false)
    {
        if ($check_point_id) {
            $check_point = CheckPoint::with('sub_zones')->find($check_point_id);
        } else {
            $check_point = false;
        }

        $sub_zones = SubZone::where('zone_id',$zone_id)->get();

        return view('client.check-point.sub-zones',compact('sub_zones','check_point'));
    }
}
