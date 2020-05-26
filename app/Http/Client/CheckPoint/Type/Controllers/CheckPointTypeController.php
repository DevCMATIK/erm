<?php

namespace App\Http\Client\CheckPoint\Type\Controllers;

use App\App\Traits\Views\HasNavBarTrait;
use App\Domain\Client\CheckPoint\CheckPoint;
use App\Domain\Client\CheckPoint\Type\CheckPointType;
use App\Http\Client\CheckPoint\Type\Requests\CheckPointTypeRequest;
use App\App\Controllers\Controller;
use Illuminate\Support\Str;

class CheckPointTypeController extends Controller
{
    use HasNavBarTrait;

    public function index()
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

        return view('client.check-point.type.index',compact('navBar'));
    }

    public function create()
    {
        return view('client.check-point.type.create');
    }

    public function store(CheckPointTypeRequest $request)
    {
        if (CheckPointType::findBySlug(Str::slug($request->name))) {
            return $this->slugError();
        } else {
            if ($new = CheckPointType::create([
                'slug' => $request->name,
                'name' => $request->name
            ])) {
                addChangeLog('Tipo Punto de control Creado','check_point_types',null,convertColumns($new));

                return $this->getResponse('success.store');
            } else {
                return $this->getResponse('error.store');
            }
        }
    }

    public function edit($id)
    {
        $type = CheckPointType::findOrFail($id);
        return view('client.check-point.type.edit',compact('type'));
    }

    public function update(CheckPointTypeRequest $request,$id)
    {
        $type = CheckPointType::findOrFail($id);
        $old = convertColumns($type);
        if(CheckPointType::slugExists(Str::slug($request->name),$id)) {
            return $this->slugError();
        } else {
            if ($type->update([
                'slug' => $request->name,
                'name' => $request->name
            ])) {
                addChangeLog('Tipo Punto de control Modificado','check_point_types',$old,convertColumns($type));

                return $this->getResponse('success.update');
            } else {
                return $this->getResponse('error.update');
            }
        }
    }

    public function destroy($id)
    {
        $type = CheckPointType::findOrFail($id);
        if ($type->delete()) {
            addChangeLog('Tipo Punto de control Eliminado','check_point_types',convertColumns($type));

            return $this->getResponse('success.destroy');
        } else {
            return $this->getResponse('error.destroy');
        }
    }
}
