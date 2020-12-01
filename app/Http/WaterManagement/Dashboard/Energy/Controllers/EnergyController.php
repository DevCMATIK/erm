<?php

namespace App\Http\WaterManagement\Dashboard\Energy\Controllers;

use App\Domain\Client\Zone\Sub\SubZone;
use App\Http\WaterManagement\Dashboard\CheckPoint\Kpi\CheckPointCostKpiController;
use App\App\Controllers\Controller;
use Sentinel;

class EnergyController extends Controller
{
    public function index($subZone)
    {
        if(!Sentinel::getUser()->inSubZone($subZone)) {
            abort(404);
        }
        $subZone = $this->getData($subZone);
        return view('water-management.dashboard.energy.index',[
            'subZone' => $subZone,
        ]);
    }

    protected function getData($id)
    {
        return SubZone::with(['configuration'])->has('configuration')->findOrFail($id);
    }
}
