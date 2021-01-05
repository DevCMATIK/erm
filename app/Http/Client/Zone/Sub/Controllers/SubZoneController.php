<?php

namespace App\Http\Client\Zone\Sub\Controllers;

use App\Domain\Client\Zone\Sub\SubZone;
use App\Domain\Client\Zone\Zone;
use App\Http\Client\Zone\Sub\Requests\SubZoneRequest;
use App\App\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubZoneController extends Controller
{
    public function index(Request $request)
    {

        return view('client.zone.sub.index',['zone' => $request->zone]);
    }

    public function create(Request $request)
    {
        return view('client.zone.sub.create',['zone' => $request->zone]);
    }

    public function store(SubZoneRequest $request)
    {
        if (SubZone::findBySlug(Str::slug($request->name))) {
            return $this->slugError();
        } else {
            if ($sub_zone = SubZone::create([
                'slug' => $request->name,
                'name' => $request->name,
                'zone_id' => Zone::findBySlug($request->zone)->id
            ])) {
                foreach($sub_zone->zone->production_areas as $production_area) {
                    foreach($production_area->users as $user) {
                        $user->sub_zones()->syncWithoutDetaching($sub_zone->id);
                    }
                }
                return $this->getResponse('success.store');
            } else {
                return $this->getResponse('error.store');
            }
        }
    }

    public function edit($id)
    {
        $zone = SubZone::findOrFail($id);
        return view('client.zone.sub.edit',compact('zone'));
    }

    public function update(SubZoneRequest $request,$id)
    {
        $zone = SubZone::findOrFail($id);
        if(SubZone::slugExists(Str::slug($request->name),$id)) {
            return $this->slugError();
        } else {
            if ($zone->update([
                'slug' => $request->name,
                'name' => $request->name
            ])) {
                return $this->getResponse('success.update');
            } else {
                return $this->getResponse('error.update');
            }
        }
    }

    public function destroy($id)
    {
        $zone = SubZone::findOrFail($id);
        if ($zone->delete()) {
            return $this->getResponse('success.destroy');
        } else {
            return $this->getResponse('error.destroy');
        }
    }
}
