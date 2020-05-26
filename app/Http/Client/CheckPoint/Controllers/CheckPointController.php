<?php

namespace App\Http\Client\CheckPoint\Controllers;

use App\App\Traits\Views\HasNavBarTrait;
use App\Domain\Client\CheckPoint\CheckPoint;
use App\Domain\Client\CheckPoint\Type\CheckPointType;
use App\Domain\Client\Zone\Sub\SubZone;
use App\Domain\Client\Zone\Zone;
use App\Http\Client\CheckPoint\Requests\CheckPointRequest;
use App\App\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CheckPointController extends Controller
{
    use HasNavBarTrait;



    public function index(Request $request)
    {
        $checkPointTypes = CheckPointType::with([
            'check_points.devices.sensors'
        ])->get();
        $navBar = $this->makeNavBar($checkPointTypes,[
            'check_point_types' => [
                'url' => '/check-points?type=',
                'field' => 'slug',
                'name' => 'name',
                'alter' => 'Ver Check Points'
            ],
            'check_points' => [
                'url' => '/devices?check_point_id=',
                'field' => 'id',
                'name' => 'name',
                'alter' => 'Ver Dispositivos'
            ],
            'devices' => [
                'url' => '/sensors?device_id=',
                'field' => 'id',
                'name' => 'name',
                'alter' => 'Ver Sensores'
            ],
            'sensors' => [
                'name' => 'full_address'
            ]
        ]);
        $type = $request->type;
        return view('client.check-point.index',compact('navBar','type'));
    }

    public function create(Request $request)
    {
        $types = CheckPointType::get();
        $zones = Zone::with('sub_zones')->has('sub_zones')->get();
        $type = $request->type;
        return view('client.check-point.create',compact('types','zones', 'type'));
    }

    public function store(CheckPointRequest $request)
    {

            if ($checkPoint = CheckPoint::create(array_merge([
                'slug' => $request->name,
                'type_id' => CheckPointType::findBySlug($request->type)->id
            ], $request->all()))) {
                if(isset($request->sub_zone_id) && count($request->sub_zone_id) > 0) {
                    $checkPoint->sub_zones()->attach(array_values($request->sub_zone_id));
                } else {
                    $checkPoint->delete();
                    return response()->json(['error' => 'No ha seleccionado Sub Zonas'],401);
                }
                addChangeLog('Punto de Control Cread0','check_points',null,convertColumns($checkPoint));
                return $this->getResponse('success.store');
            } else {
                return $this->getResponse('error.store');
            }

    }

    public function edit($id)
    {
        $checkPoint = CheckPoint::with('sub_zones')->findOrFail($id);
        $types = CheckPointType::get();
        $zones = Zone::with('sub_zones')->has('sub_zones')->get();
        return view('client.check-point.edit',compact('checkPoint','types','zones'));
    }

    public function update(CheckPointRequest $request,$id)
    {
        $checkPoint = CheckPoint::findOrFail($id);
        $old = convertColumns($checkPoint);
            if ($checkPoint->update(array_merge([
                'slug' => $request->name
            ], $request->all()))) {
                if(isset($request->sub_zone_id) && count($request->sub_zone_id) > 0) {
                    $checkPoint->sub_zones()->detach();
                    $checkPoint->sub_zones()->attach(array_values($request->sub_zone_id));
                } else {
                    return response()->json(['error' => 'No ha seleccionado Sub Zonas'],401);
                }
                addChangeLog('Punto de control Modificado','check_points',$old,convertColumns($checkPoint));
                return $this->getResponse('success.update');
            } else {
                return $this->getResponse('error.update');
            }

    }

    public function destroy($id)
    {
        $checkPoint = CheckPoint::findOrFail($id);
        $checkPoint->devices()->delete();
        $checkPoint->sub_zones()->detach();
        $checkPoint->sub_element()->delete();
        if ($checkPoint->delete()) {
            addChangeLog('Punto de control Eliminado','check_points',$checkPoint);
            return $this->getResponse('success.destroy');
        } else {
            return $this->getResponse('error.destroy');
        }
    }
}
