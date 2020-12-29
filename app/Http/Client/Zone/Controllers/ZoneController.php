<?php

namespace App\Http\Client\Zone\Controllers;

use App\App\Controllers\Controller;
use App\Domain\Client\Zone\Zone;
use App\Http\Client\Zone\Requests\ZoneRequest;
use Illuminate\Support\Str;

class ZoneController extends Controller
{
    public function index()
    {
        return view('client.zone.index');
    }

    public function create()
    {
        return view('client.zone.create');
    }

    public function store(ZoneRequest $request)
    {
        if (Zone::findBySlug(Str::slug($request->name))) {
            return $this->slugError();
        } else {
            if (Zone::create([
                'slug' => $request->name,
                'name' => $request->name,
                'display_name' => $request->display_name
            ])) {
                return $this->getResponse('success.store');
            } else {
                return $this->getResponse('error.store');
            }
        }
    }

    public function edit($id)
    {
        $zone = Zone::findOrFail($id);
        return view('client.zone.edit',compact('zone'));
    }

    public function update(ZoneRequest $request,$id)
    {
        $record = Zone::findOrFail($id);
        if(Zone::slugExists(Str::slug($request->name),$id)) {
            return $this->slugError();
        } else {
            if ($record->update([
                'slug' => $request->name,
                'name' => $request->name,
                'display_name' => $request->display_name
            ])) {
                return $this->getResponse('success.update');
            } else {
                return $this->getResponse('error.update');
            }
        }
    }

    public function destroy($id)
    {
        $record = Zone::findOrFail($id);
        if ($record->delete()) {
            return $this->getResponse('success.destroy');
        } else {
            return $this->getResponse('error.destroy');
        }
    }
}
