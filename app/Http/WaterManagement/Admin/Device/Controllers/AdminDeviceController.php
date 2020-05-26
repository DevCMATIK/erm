<?php

namespace App\Http\WaterManagement\Admin\Device\Controllers;

use App\App\Controllers\Controller;
use App\Domain\Client\CheckPoint\CheckPoint;
use App\Domain\Client\Zone\Sub\SubZone;
use App\Domain\Client\Zone\Zone;

class AdminDeviceController extends Controller
{
    public function index()
    {
        $zones = Zone::get();
        return view('water-management.admin.device.index', compact('zones'));
    }

    public function getSubZonesCombo($zone_id)
    {
        $subZones = SubZone::where('zone_id',$zone_id)->get();
        $html = '
               <label class="form-label">Sub Zonas</label>
               <select class="form-control"  id="sub_zone" onchange="getDataFromSubZone()">
               <option value="">Seleccione...</option>';

        foreach ($subZones as $sub) {
            $html = $html . '<option value="'.$sub->id.'">'.$sub->name.'</option>';
        }

        return $html.' </select> ';
    }

    public function adminSubZone($sub_zone_id)
    {
        $subZone = SubZone::with([
            'check_points.type',
            'check_points.devices.sensors',
            'check_points.devices.sensors.address',
            'check_points.devices.type'
        ])->find($sub_zone_id);
        return view('water-management.admin.device.sub-zone',compact('subZone'));
    }
}
