<?php

namespace App\Http\WaterManagement\Group\Controllers;

use App\App\Controllers\Controller;
use App\Domain\Client\Zone\Sub\SubZone;
use App\Domain\WaterManagement\Group\Group;
use App\Http\WaterManagement\Group\Requests\GroupRequest;
use Illuminate\Support\Str;

class GroupController extends Controller
{
    public function index()
    {
        return view('water-management.group.index');
    }

    public function create()
    {
        return view('water-management.group.create');
    }

    public function store(GroupRequest $request)
    {
        if (Group::findBySlug(Str::slug($request->name))) {
            return $this->slugError();
        } else {
            if (Group::create([
                'slug' => $request->name,
                'name' => $request->name
            ])) {
                return $this->getResponse('success.store');
            } else {
                return $this->getResponse('error.store');
            }
        }
    }

    public function edit($id)
    {
        $group = Group::findOrFail($id);
        return view('water-management.group.edit',compact('group'));
    }

    public function update(GroupRequest $request,$id)
    {
        $group = Group::findOrFail($id);
        if(Group::slugExists(Str::slug($request->name),$id)) {
            return $this->slugError();
        } else {
            if ($group->update([
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
        $group = Group::findOrFail($id);
        if ($group->delete()) {
            return $this->getResponse('success.destroy');
        } else {
            return $this->getResponse('error.destroy');
        }
    }
}
