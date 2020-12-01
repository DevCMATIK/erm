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
            'types' =>   $subZone->elements->map(function($element){
                return $element->sub_elements->map(function($sub_element){
                    return $sub_element->analogous_sensors->map(function($item){
                        return $item;
                    });
                });
            })->collapse()->collapse()->groupBy('sensor.type.slug')->map(function($item,$key){
                return $item->groupBy('sensor.name');
            })
        ]);
    }

    protected function getData($id)
    {
        return SubZone::with([
                'configuration',
                'elements.sub_elements.digital_sensors.sensor.label',
                'elements.sub_elements.analogous_sensors.sensor',
                'elements.sub_elements.analogous_sensors.sensor.type.interpreters',
                'elements.sub_elements.analogous_sensors.sensor.dispositions.unit',
                'elements.sub_elements.active_alarm',
                'elements.sub_elements.active_and_not_accused_alarm',
                'elements.sub_elements.check_point'
            ])->has('configuration')->findOrFail($id);
    }
}
