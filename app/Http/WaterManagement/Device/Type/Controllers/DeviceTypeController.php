<?php

namespace App\Http\WaterManagement\Device\Type\Controllers;

use App\App\Controllers\Controller;
use App\Domain\WaterManagement\Device\Type\DeviceType;
use App\Http\WaterManagement\Device\Type\Requests\DeviceTypeRequest;
use Illuminate\Support\Str;

class DeviceTypeController extends Controller
{
    public function index()
    {
        return view('water-management.device.type.index');
    }

    public function create()
    {
        return view('water-management.device.type.create');
    }

    public function store(DeviceTypeRequest $request)
    {
        if (DeviceType::findBySlug(Str::slug($request->name))) {
            return $this->slugError();
        } else {
            if (DeviceType::create([
                'slug' => $request->name,
                'name' => $request->name,
                'model' => $request->model,
                'brand' => $request->brand
            ])) {
                //addChangeLog('Tipo Dispositivo Modificado','device_type',null,convertColumns($new));

                return $this->getResponse('success.store');
            } else {
                return $this->getResponse('error.store');
            }
        }
    }

    public function edit($id)
    {
        $type = DeviceType::findOrFail($id);
        return view('water-management.device.type.edit',compact('type'));
    }

    public function update(DeviceTypeRequest $request,$id)
    {
        $type = DeviceType::findOrFail($id);
        //$old = convertColumns($type);
        if(DeviceType::slugExists(Str::slug($request->name),$id)) {
            return $this->slugError();
        } else {
            if ($type->update([
                'slug' => $request->name,
                'name' => $request->name,
                'model' => $request->model,
                'brand' => $request->brand
            ])) {
                //addChangeLog('Tipo Dispositivo Modificado','device_types',$old,convertColumns($type));

                return $this->getResponse('success.update');
            } else {
                return $this->getResponse('error.update');
            }
        }
    }

    public function destroy($id)
    {
        $type = DeviceType::findOrFail($id);
        if ($type->delete()) {
            //addChangeLog('Tipo Dispositivo Eliminado','device_types',$type);

            return $this->getResponse('success.destroy');
        } else {
            return $this->getResponse('error.destroy');
        }
    }
}
