<?php

namespace App\Http\WaterManagement\Dashboard\Controllers;

use App\Domain\Client\CheckPoint\CheckPoint;
use App\Domain\Client\Zone\Sub\SubZone;
use App\Domain\Client\Zone\Sub\SubZoneSubElement;
use App\Domain\Client\Zone\Zone;
use App\Domain\WaterManagement\Device\Consumption\DeviceConsumption;
use App\Domain\WaterManagement\Device\Device;
use App\Domain\WaterManagement\Device\Sensor\Electric\ElectricityConsumption;
use App\Http\Client\CheckPoint\Controllers\CheckPointIndicatorsController;
use App\Http\WaterManagement\Dashboard\CheckPoint\Kpi\CheckPointCostKpiController;
use App\Http\WaterManagement\Dashboard\CheckPoint\Kpi\CheckPointKpiController;
use Sentinel;
use App\App\Controllers\Controller;

class DashboardController extends Controller
{
    public function dashboardMain()
    {
        $zones = Zone::whereHas('sub_zones', $filter =  function($query){
            $query->whereIn('id',Sentinel::getUser()->getSubZonesIds())->whereHas('configuration');
        })->with( ['sub_zones' => $filter])->get();
        return view('water-management.dashboard.views.main',compact('zones'));
    }

    public function subZoneDashboard($sub_zone_id)
    {
        if(!Sentinel::getUser()->inSubZone($sub_zone_id)) {
            abort(404);
        }
        $subZone = $this->getData($sub_zone_id);
        $columns = $this->getColumns($subZone);
        $subColumns = $this->getSubColumns($subZone);
        $check_points = $subZone->check_points->implode('id',',');
        $check_point_kpis = app(CheckPointCostKpiController::class)->getCostKpi($check_points);
        if($subZone->zone->area_id == 2) {
            return view('water-management.dashboard.views.sub-zone-electric',compact('subZone', 'columns','subColumns','check_point_kpis'));
        } else {
            return view('water-management.dashboard.views.sub-zone',compact('subZone', 'columns','subColumns','check_point_kpis'));
        }
    }

    public function getDashboardContent($sub_zone_id)
    {
        if(!Sentinel::getUser()->inSubZone($sub_zone_id)) {
            abort(404);
        }
        $subZone = $this->getData($sub_zone_id);
        $columns = $this->getColumns($subZone);
        $subColumns = $this->getSubColumns($subZone);


        return view('water-management.dashboard.views.content',compact('subZone', 'columns','subColumns'));

    }

    public function getDashboardContentElectric($sub_zone_id)
    {
        if(!Sentinel::getUser()->inSubZone($sub_zone_id)) {
            abort(404);
        }
        $subZone = $this->getData($sub_zone_id);
        $columns = $this->getColumns($subZone);
        $subColumns = $this->getSubColumns($subZone);
        $check_points = $subZone->check_points->implode('id',',');
        $check_point_kpis = app(CheckPointCostKpiController::class)->getCostKpi($check_points,true);
        $sub_zone = SubZone::with('zone')->find($sub_zone_id);
        $sub_zones_id = SubZone::where('zone_id',$subZone->zone_id)->get()->pluck('id')->toArray();

        $last_month_consumption  = ElectricityConsumption::whereIn('sub_zone_id',$sub_zones_id)->where('sensor_type','ee-e-activa')->lastMonth('date')->get()->sum('consumption');
        $last_month_sub_zone  = ElectricityConsumption::where('sub_zone_id',$sub_zone_id)->where('sensor_type','ee-e-activa')->lastMonth('date')->get()->sum('consumption');
        $this_month_sub_zone  = ElectricityConsumption::where('sub_zone_id',$sub_zone_id)->where('sensor_type','ee-e-activa')->thisMonth('date')->get()->sum('consumption');
        $this_month_consumption  = ElectricityConsumption::whereIn('sub_zone_id',$sub_zones_id)->where('sensor_type','ee-e-activa')->thisMonth('date')->get()->sum('consumption');

        return view('water-management.dashboard.views.content-electric',compact('subZone', 'columns','subColumns','check_point_kpis','last_month_consumption','this_month_consumption','last_month_sub_zone','this_month_sub_zone'));

    }

    public function controlDashboard($sub_zone_id)
    {
        if(!Sentinel::getUser()->hasAccess('dashboard.control-mode')) {
            abort(404);
        }
        $subZone = $this->getData($sub_zone_id);
        $columns = $this->getColumns($subZone,true);
        $subColumns = $this->getSubColumns($subZone);
        return view('water-management.dashboard.views.control',compact('subZone', 'columns','subColumns'));
    }

    public function getControlContent($sub_zone_id){
        if(!Sentinel::getUser()->hasAccess('dashboard.control-mode')) {
            abort(404);
        }
        $subZone = $this->getData($sub_zone_id);
        $columns = $this->getColumns($subZone,true);
        $subColumns = $this->getSubColumns($subZone);
        return view('water-management.dashboard.views.control-content',compact('subZone', 'columns','subColumns'));

    }

    public function deviceDashboard($check_point)
    {
        $sub_elements = $this->getData($check_point,true);
        $subColumns = $this->getSubElementColumnsDevice($sub_elements);
        $subZone = SubZone::with([
            'sub_elements.active_alarm',
            'sub_elements.check_point.devices',
            'sub_elements.check_point.grids',
        ])->find($sub_elements->first()->parent->sub_zone_id);
        $chk = CheckPoint::with([
            'authorized_flow',
            'flow_averages',
            'totalizers',
            'indicators'
        ])->find($check_point);
        $flow = app(CheckPointKpiController::class)->getFlowKpi($check_point);
        $totalizer = app(CheckPointKpiController::class)->getTotalizerKpi($check_point);
        $costs = app(CheckPointCostKpiController::class)->getCostKpi($check_point,true);

        if(count($chk->indicators) > 0) {
            $indicators = app(CheckPointIndicatorsController::class)->getIndicators($check_point);
        } else {
            $indicators = false;
        }

        return view('water-management.dashboard.views.device',compact('sub_elements','subColumns','subZone','check_point','flow','totalizer','costs','indicators'));
    }

    public function getDeviceContent($check_point)
    {
        $sub_elements = $this->getData($check_point,true);
        $subColumns = $this->getSubElementColumnsDevice($sub_elements);
        $subZone = SubZone::with([
            'sub_elements.device'
        ])->find($sub_elements->first()->parent->sub_zone_id);
        $chk = CheckPoint::with([
            'authorized_flow',
            'flow_averages',
            'totalizers',
            'indicators'
        ])->find($check_point);

        if(count($chk->indicators) > 0) {
            $indicators = app(CheckPointIndicatorsController::class)->getIndicators($check_point);
        } else {
            $indicators = false;
        }
        return view('water-management.dashboard.views.device-content',compact('sub_elements','subColumns','subZone','check_point','indicators'));
    }

    protected function getData($id,$check_point = false)
    {
        if ($check_point) {
            return SubZoneSubElement::with([
                'parent.sub_zone',
                'active_alarm',
                'active_and_not_accused_alarm',
                'digital_sensors.sensor.label',
                'digital_sensors.sensor.device.report',
                'analogous_sensors.sensor',
                'analogous_sensors.sensor.type.interpreters',
                'analogous_sensors.sensor.dispositions.unit',
                'analogous_sensors.sensor.ranges',
                'analogous_sensors.sensor.device.report',
                'check_point',
            ])->where('check_point_id',$id)->get();
        } else {
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

    protected function getColumns($subZone, $outputs = false)
    {
        if($outputs) {
            return ( $subZone->elements->filter(function($item){
                return (count($item->sub_elements->filter(function($sub_element){
                        return count($sub_element->digital_sensors->filter(function($digital_sensor) {
                            return ($digital_sensor->sensor->address->slug == 'o' && $digital_sensor->use_as_digital_chart == 0);
                        })) > 0;
                    })) > 0);
            })->count());
        } else {
            return $subZone->elements->filter(function($item){
                return $item->sub_elements->count() > 0;
            })->count();
        }

    }

    protected function getSubColumns($subZone)
    {
        $sub_elements = array();

        foreach($subZone->elements as $element){
            foreach($element->sub_elements as $sub_element) {
                array_push($sub_elements, [
                    'sub_element' => $sub_element->id,
                    'sub_columns' => $this->getSubElementColumns($sub_element)
                ]);
            }
        }
        return collect(array_values($sub_elements));
    }

    protected function getSubElementColumns($sub_element)
    {
        $subColumns = array();
        if($sub_element->digital_sensors->where('show_in_dashboard',1)->where('use_as_digital_chart',0)->count() > 0) {
            array_push($subColumns,array('digital' => 1));
        }
        if($sub_element->analogous_sensors->where('show_in_dashboard',1)->where('use_as_chart',0)->count() > 0) {
            array_push($subColumns,array('analogous' => 1));
        }
        if($sub_element->analogous_sensors->where('use_as_chart',1)->first()) {
            array_push($subColumns,array('graph' => 1));
        }

        return $subColumns;
    }

    protected function getSubElementColumnsDevice($sub_elements)
    {
        $subColumns = array();
        $sub_element = $sub_elements->first();
            if($sub_element->digital_sensors->where('show_in_dashboard',1)->where('use_as_digital_chart',0)->count() > 0) {
                array_push($subColumns,array('digital' => 1));
            }
            if($sub_element->analogous_sensors->where('show_in_dashboard',1)->where('use_as_chart',0)->count() > 0) {
                array_push($subColumns,array('analogous' => 1));
            }
            if($sub_element->analogous_sensors->where('use_as_chart',1)->first()) {
                array_push($subColumns,array('graph' => 1));
            }



        return $subColumns;
    }

}
