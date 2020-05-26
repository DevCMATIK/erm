<?php

namespace App\Http\WaterManagement\Admin\Panel;

use App\Domain\Client\Zone\Sub\SubZone;
use App\Domain\Client\Zone\Zone;
use App\App\Controllers\Controller;

class AdminPanelController extends Controller
{
    public function index()
    {
        //work
        $zones = Zone::get();
        return view('water-management.admin.panel.index', compact('zones'));
    }

    public function adminSubZone($sub_zone_id)
    {
        $subZone = SubZone::with([
            'configuration',
        ])->find($sub_zone_id);
        if(!$subZone->configuration)
        {
            $subZone->configuration()->create(['columns' => 1]);
            $subZone = SubZone::with([
                'configuration',
            ])->find($sub_zone_id);
        }
        return view('water-management.admin.panel.admin',compact('subZone'));
    }

    public function changeColumns($sub_zone_id,$columns)
    {
        SubZone::find($sub_zone_id)->configuration()->update([
            'columns' => $columns
        ]);
    }

    public function changeBlocked($sub_zone_id,$checked)
    {
        $subZone = SubZone::with('configuration')->find($sub_zone_id);
        if ($checked == 1) {
            $subZone->configuration()->update(['block_columns' => 1]);
            for ($i = 1; $i <= $subZone->configuration->columns; $i++) {
                $subZone->elements()->create([
                    'column' => $i
                ]);
            }
        } else {
            $subZone->configuration()->update(['block_columns' => 0]);
            $subZone->elements()->delete();
        }
    }

    public function getColumns($sub_zone_id)
    {
        $subZone = SubZone::with([
            'check_points.type',
            'check_points.devices.sensors',
            'check_points.devices.sensors.address',
            'check_points.devices.type',
            'configuration',
            'elements.sub_elements.check_point'
        ])->find($sub_zone_id);
        return view('water-management.admin.panel.partials.columns',compact('subZone'));

    }

}
