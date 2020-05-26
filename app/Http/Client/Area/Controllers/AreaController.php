<?php

namespace App\Http\Client\Area\Controllers;

use App\Domain\Client\Area\Area;
use App\Domain\Client\Zone\Zone;
use App\Http\Client\Area\Requests\AreaRequest;
use App\App\Controllers\Controller;
use Illuminate\Support\Str;

class AreaController extends Controller
{
    public function index()
    {
        return view('client.area.index');
    }

    public function create()
    {
        return view('client.area.create');
    }

    public function store(AreaRequest $request)
    {
        if (Area::findBySlug(Str::slug($request->name))) {
            return $this->slugError();
        } else {
            if ($area = Area::create([
                'slug' => $request->name,
                'name' => $request->name,
                'icon' => $request->icon ?? null
            ])) {
                addChangeLog('Area Creada','areas',null,convertColumns($area));
                return $this->getResponse('success.store');
            } else {
                return $this->getResponse('error.store');
            }
        }
    }

    public function edit($id)
    {
        $area = Area::findOrFail($id);
        return view('client.area.edit',compact('area'));
    }

    public function update(AreaRequest $request,$id)
    {
        $area = Area::findOrFail($id);
        $old = convertColumns($area);
        if(Area::slugExists(Str::slug($request->name),$id)) {
            return $this->slugError();
        } else {
            if ($area->update([
                'slug' => $request->name,
                'name' => $request->name,
                'icon'=> $request->icon ?? null
            ])) {
                addChangeLog('Area Modificada','areas',$old,convertColumns($area));
                return $this->getResponse('success.update');
            } else {
                return $this->getResponse('error.update');
            }
        }
    }

    public function destroy($id)
    {
        $area = Area::findOrFail($id);
        Zone::where('area_id',$id)->update([
            'area_id' => null
        ]);

        if ($area->delete()) {
            addChangeLog('Area Eliminada','areas',convertColumns($area));
            return $this->getResponse('success.destroy');
        } else {
            return $this->getResponse('error.destroy');
        }
    }
}
