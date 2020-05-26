<?php

namespace App\Http\WaterManagement\Admin\Device\Controllers;

use App\Domain\WaterManagement\Device\Sensor\Disposition\SensorDisposition;
use App\Domain\WaterManagement\Device\Sensor\Sensor;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;

class TestValueController extends Controller
{
    public function __invoke($sensor_id, $disposition_id)
    {
        $sensor = Sensor::with(['address','device.report','label'])->find($sensor_id);
        $disposition = SensorDisposition::with('unit')->find($disposition_id);
        $value = $this->calculateAnalogousValue($sensor,$disposition);

        return view('water-management.admin.device.value-test',compact('sensor','disposition','value'));
     }

    protected function calculateAnalogousValue($sensor,$disposition)
    {
        $value = array();
        $address = $sensor->full_address;
        $value['valorReport']  = $sensor->device->report->{$address}; // 0, 400
        $value['ingMin'] = $disposition->sensor_min;
        $value['ingMax'] = $disposition->sensor_max;
        $value['scaleMin'] = $disposition->scale_min;
        $value['scaleMax'] = $disposition->scale_max;
        if($value['scaleMin'] == null && $value['scaleMax'] == null) {
            $data = ($value['ingMin'] * $value['valorReport']) + $value['ingMax'];
            $value['formula'] = '(ingMin * valorReport) + ingMax';
        } else {
            $f1 = $value['ingMax'] - $value['ingMin'];
            $f2 = $value['scaleMax'] - $value['scaleMin'];
            $f3 = $value['valorReport'] - $value['scaleMin'];
            if($f2 == 0) {
                $data = ((0)*($f3)) + $value['ingMin'] ;
            } else {
                $data = (($f1/$f2)*($f3)) + $value['ingMin'] ;
            }
            $value['formula'] = '(((ingMax - ingMin)/(scaleMax - scaleMin))*(valorReport - scaleMin)) + ingMin';
        }
        $value['data'] = number_format($data,$disposition->precision,',','');
        return  $value;
    }

    protected function calculateDigitalValue($sensor)
    {
        $address = $sensor->full_address;
        if($sensor->device->report->{$address} === 1) {
            return $sensor->label->on_label;
        } else {
            return $sensor->label->off_label;
        }
    }
}
