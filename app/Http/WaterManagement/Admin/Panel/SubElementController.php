<?php

namespace App\Http\WaterManagement\Admin\Panel;

use App\Domain\Client\Zone\Sub\SubElementSensor;
use App\Domain\Client\Zone\Sub\SubZoneSubElement;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;

class SubElementController extends Controller
{
    public function index($sub_element_id)
    {
        $sub_element = $this->checkSensors($sub_element_id);
        return view('water-management.admin.panel.sub-element',compact('sub_element'));
    }

    public function updateSensors(Request $request)
    {
        $i = 1;
        foreach(explode(',',$request->items) as $item)
        {
            if ($item != '') {
                $sub_element = explode('_',$item)[1];
                $sensor = explode('_',$item)[2];
                SubElementSensor::where('sub_element_id',$sub_element)->where('sensor_id',$sensor)->first()->update(['position' => $i]);
                $i++;
            }
        }
    }

    public function showSensorInDashboard(Request $request)
    {
        $item = explode('_',$request->element);

        $se = SubElementSensor::where('sub_element_id',$item[1])->where('sensor_id',$item[2])->first();

        $se->update(['show_in_dashboard' => $request->show]);

    }

    public function useAsChart(Request $request)
    {
        $item = explode('_',$request->element);
        $sub_element = SubZoneSubElement::with('sensors')->find($item[1]);
        foreach ($sub_element->sensors as $sensor) {
            if($sensor->sensor_id == $item[2]) {
                $sensor->update(['use_as_chart' => 1]);
            } else {
                $sensor->update(['use_as_chart' => 0]);
            }
        }
    }

    public function chartNotNeeded(Request $request)
    {
        $item = explode('_',$request->element);

        $se = SubElementSensor::where('sub_element_id',$item[1])->where('sensor_id',$item[2])->first();

        $se->update(['no_chart_needed' => $item[3]]);
    }

    public function isNotAnOutput(Request $request)
    {
        $item = explode('_',$request->element);

        $se = SubElementSensor::where('sub_element_id',$item[1])->where('sensor_id',$item[2])->first();

        $se->update(['is_not_an_output' => $item[3]]);
    }

    public function useAsChartDigital(Request $request)
    {
        $item = explode('_',$request->element);
        $sub_element = SubZoneSubElement::with('sensors')->find($item[1]);
        foreach ($sub_element->sensors as $sensor) {
            if($sensor->sensor_id == $item[2]) {
                $s = $sensor;
                $sensor->update(['use_as_digital_chart' => 1]);
            } else {
                $sensor->update(['use_as_digital_chart' => 0]);
            }
        }

        return view('water-management.admin.panel.digital-meanings',compact('s'));
    }

    public function updateDigitalMeanings(Request $request,$id)
    {
        $sensor = SubElementSensor::find($id);
        $sensor->means_up = $request->means_up ?? null;
        $sensor->means_down = $request->means_down ?? null;
        $sensor->save();

        return $this->getResponse('success.store');
    }

    protected function checkSensors($sub_element_id)
    {
        $sub_element = SubZoneSubElement::with('sensors.sensor.address','check_point.devices.sensors')->find($sub_element_id);
        foreach($sub_element->check_point->devices as $device) {
            $sensors = $device->sensors
                ->pluck('id')
                ->flatten()
                ->diff(
                    $sub_element
                        ->sensors()
                        ->pluck('sensor_id')
                        ->flatten()
                );
            if(isset($sensors) && count($sensors) > 0) {
                foreach ($sensors as $sensor)
                {
                    $sub_element->sensors()->updateOrCreate([
                        'sensor_id' => $sensor
                    ]);
                }

            }
        }

        $sub_element = SubZoneSubElement::with('sensors.sensor','check_point.devices.sensors')->find($sub_element->id);

        return $sub_element;
    }
}
