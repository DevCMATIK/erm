<?php

namespace App\Http\Data\Export;

use App\Domain\Client\CheckPoint\CheckPoint;

use App\Domain\Client\Zone\Zone;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;

use App\Domain\Client\Zone\Sub\SubZone;
use App\Exports\AlarmActiveExport;
use Rap2hpoutre\FastExcel\Exportable;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Domain\Data\Export;
use Rap2hpoutre\FastExcel\SheetCollection;

use Sentinel;
use ActiveAlarmsTableController;
use LastAlarmsTableController;


class ExportDataController extends Controller
{

    public function index()
    {
        $zones = Zone::whereHas('sub_zones', $filter =  function($query){
            $query->whereIn('id',Sentinel::getUser()->getSubZonesIds());
        })->with( ['sub_zones' => $filter])->get();
        return view('data.exports.index',compact('zones'));
    }

    public function getCheckPoints(Request $request)
    {
        $check_points = CheckPoint::with(['devices.sensors.address','devices.sensors.type'])->whereHas('sub_zones', function ($q) use ($request){
            return $q->whereIn('id',$request->sub_zones);
        })->get()->unique('id');
        return view('data.exports.check-points',compact('check_points'));
    }

}
