<?php

namespace App\Http\Data\Export;

use App\Domain\Client\CheckPoint\CheckPoint;
use App\Domain\Client\Zone\Sub\SubZone;
use App\Domain\Client\Zone\Zone;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;
use Sentinel;

class ExportDataController extends Controller
{
    public function index()
    {
        $zones = Zone::whereHas('sub_zones', $filter =  function($query){
            $query->whereIn('id',Sentinel::getUser()->getSubZonesIds())->whereHas('configuration');
        })->with( ['sub_zones' => $filter])->get();
        return view('data.exports.index',compact('zones'));
    }

    public function getCheckPoints(Request $request)
    {
        $check_points = CheckPoint::whereHas('sensors.type',$filter = function($query){
            $query->where('is_exportable',1);
        })
        ->with(['devices.sensors.address','sensors.type' => $filter])->whereHas('sub_zones', function ($q) use ($request){
            return $q->whereIn('id',$request->sub_zones);
        })->get()->unique('id');
        return view('data.exports.check-points',compact('check_points'));
    }
}
