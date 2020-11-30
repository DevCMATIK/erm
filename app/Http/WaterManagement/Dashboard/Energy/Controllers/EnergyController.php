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
        $check_point_kpis = app(CheckPointCostKpiController::class)->getCostKpi($subZone->check_points->implode('id',','));

        return view('water-management.dashboard.energy.index',compact('subZone', 'check_point_kpis'));
    }

    protected function getData($id)
    {
        return SubZone::with([
                'configuration',
                'elements.sub_elements.digital_sensors.sensor.label',
                'elements.sub_elements.digital_sensors.sensor.device.report',
                'elements.sub_elements.analogous_sensors.sensor',
                'elements.sub_elements.analogous_sensors.sensor.type.interpreters',
                'elements.sub_elements.analogous_sensors.sensor.dispositions.unit',
                'elements.sub_elements.analogous_sensors.sensor.ranges',
                'elements.sub_elements.analogous_sensors.sensor.device.report',
                'elements.sub_elements.active_alarm',
                'elements.sub_elements.active_and_not_accused_alarm',
                'elements.sub_elements.check_point'
            ])->has('configuration')->findOrFail($id);
    }
}
