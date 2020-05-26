<?php

namespace App\Http\Client\CheckPoint\Label\Controllers;

use App\Domain\Client\CheckPoint\CheckPoint;
use App\Domain\Data\Analogous\AnalogousReport;
use App\Domain\WaterManagement\Device\Sensor\Sensor;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;

class CheckPointLabelController extends Controller
{
    public function index()
    {
        $sensors = $this->getSensors();
        $data = array();
        foreach($sensors as $sensor) {
            $lastReport = AnalogousReport::with('device.check_point.sub_zones.zone')->where('device_id',$sensor->device_id)
                ->where('register_type',$sensor->register_type_id)
                ->where('address',$sensor->address)
                ->orderBy('id','desc')
                ->take(1)
                ->first();
            if($lastReport) {
                if($lastReport->result > 0) {
                    array_push($data,[
                        'check_point' => $sensor->check_point,
                        'value' => number_format($lastReport->result,1),
                        'zone' => $lastReport->device->check_point->sub_zones()->first()->zone->name,
                        'sub_zone' => $lastReport->device->check_point->sub_zones()->first()->name,
                        'position' => $lastReport->device->check_point->sub_zones()->first()->zone->position,
                        'sub_zone_position' => $lastReport->device->check_point->sub_zones()->first()->position,
                        'check_point_id' => $sensor->check_point_id,
                        'label' => $sensor->label,
                        'device_id' => $sensor->device_id,
                        'device_name' => $sensor->device_name
                    ]);
                }
            }
        }
        $data = collect($data)->sortBy('position');

        return view('client.check-point.label.index',compact('data'));
    }

    public function store(Request $request)
    {
        $i = 0;
        foreach($request->check_points as $check_point){
            $check = CheckPoint::find($check_point);
            $old = convertColumns($check->label);
            $new = $check->label()
                ->updateOrCreate([
                    'check_point_id' => $check_point,
                    'device_id' => $request->devices[$i]
                    ],[
                'label' => $request->labels[$i]
            ]);

            addChangeLog('Nombre de Punton de Control ','check_point_labels',$old,convertColumns($new));

            $i++;
        }

        return response()->json(['success' => 'Etiquetas guardadas correctamente']);
    }

    protected function getSensors()
    {
        return Sensor::leftJoin('devices','devices.id','=','sensors.device_id')
            ->leftJoin('check_points','check_points.id','=','devices.check_point_id')
            ->leftJoin('check_point_labels','devices.id','=','check_point_labels.device_id')
            ->leftJoin('check_point_types','check_point_types.id','=','check_points.type_id')
            ->leftJoin('addresses','addresses.id','=','sensors.address_id')
            ->where('sensors.type_id',1)
            ->whereNull('devices.deleted_at')
            ->whereNull('check_points.deleted_at')
            ->whereRaw("(check_point_types.slug = 'copas' or check_point_types.slug = 'relevadoras') and addresses.register_type_id = 11")
            ->selectRaw('check_points.name as check_point,check_points.id as check_point_id,check_point_labels.label as label,sensors.address_number as address,addresses.register_type_id,devices.id as device_id,devices.name as device_name')
            ->get();
    }
}
