<?php

namespace App\Http\Client\CheckPoint\Label\Controllers;

use App\Domain\Client\CheckPoint\CheckPoint;
use App\Domain\Client\Zone\Zone;
use App\Domain\Data\Analogous\AnalogousReport;
use App\Domain\WaterManagement\Device\Sensor\Sensor;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;
use Sentinel;

class CheckPointLabelController extends Controller
{
    public function index()
    {
        $sensors = $this->getSensors();
        $data = array();
        foreach($sensors as $sensor) {
            array_push($data,[
                        'check_point' => $sensor->device->check_point->name,
                        'zone' => $sensor->device->check_point->sub_zones()->first()->zone->name,
                        'sub_zone' => $sensor->device->check_point->sub_zones()->first()->name,
                        'position' => $sensor->device->check_point->sub_zones()->first()->zone->position,
                        'sub_zone_position' => $sensor->device->check_point->sub_zones()->first()->position,
                        'check_point_id' => $sensor->device->check_point_id,
                        'label' => $sensor->device->check_point->label->first()->label ?? '',
                        'device_id' => $sensor->device_id,
                        'device_name' => $sensor->device->name
                    ]);
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

            addChangeLog('Nombre de Punto de Control ','check_point_labels',$old,convertColumns($new));

            $i++;
        }

        return response()->json(['success' => 'Etiquetas guardadas correctamente']);
    }



    protected function getZones()
    {
        $user_sub_zones = Sentinel::getUser()->sub_zones()->pluck('id')->toArray();

        return Zone::with([
            'sub_zones.configuration',
            'sub_zones.sub_elements'
        ])->get()->filter(function($item) use($user_sub_zones){
            return $item->sub_zones->filter(function($sub_zone)  use ($user_sub_zones){
                    return in_array($sub_zone->id,$user_sub_zones) && isset($sub_zone->configuration);
                })->count() > 0;
        });
    }

    protected function getDevicesId()
    {
        $ids = array();

        foreach($this->getZones() as $zone) {
            foreach($zone->sub_zones as $sub_zone) {
                foreach($sub_zone->sub_elements as $sub_element) {
                    array_push($ids,$sub_element->device_id);
                }
            }
        }

        return $ids;
    }

    protected function getSensors()
    {
        return Sensor::query()->with([
            'type.interpreters',
            'dispositions.unit',
            'device.report',
            'device.check_point.sub_zones.zone',
            'device.check_point.type',
            'device.check_point.label',
            'ranges'
        ])
            ->where('type_id',32)
            ->where('address_id',1)
            ->whereIn('device_id', function($query) {
                $query->select('id')->from('devices')->whereIn('check_point_id',function($query) {
                    $query->select('id')->from('check_points')->wherein('type_id',function($query){
                        $query->select('id')->from('check_point_types')->whereIn('slug',['copas','relevadoras']);
                    });
                });
            })
            ->whereIn('device_id',$this->getDevicesId())
            ->get();
    }
}
