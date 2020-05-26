<?php

namespace App\Http\Inspection\CheckList\Controllers;

use App\Domain\Client\CheckPoint\Type\CheckPointType;
use App\Domain\Inspection\CheckList\CheckList;
use App\Http\Inspection\CheckList\Requests\CheckListRequest;
use App\App\Controllers\Controller;
use Illuminate\Support\Str;

class CheckListController extends Controller
{
    public function index()
    {
        return view('inspection.check-list.index');
    }

    public function create()
    {
        $checkPoints = CheckPointType::get();
        return view('inspection.check-list.create',compact('checkPoints'));
    }

    public function store(CheckListRequest $request)
    {
        if (CheckList::findBySlug(Str::slug($request->name))) {
            return $this->slugError();
        } else {
            if (CheckList::create([
                'check_point_type_id' => $request->check_point_type_id,
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
        $checkList = CheckList::with('check_point_type')->findOrFail($id);
        $checkPoints = CheckPointType::get();
        return view('inspection.check-list.edit',compact('checkList','checkPoints'));
    }

    public function update(CheckListRequest $request,$id)
    {
        $checkList = CheckList::findOrFail($id);
        if(CheckList::slugExists(Str::slug($request->name),$id)) {
            return $this->slugError();
        } else {
            if ($checkList->update([
                'check_point_type_id' => $request->check_point_type_id,
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
        $checkList = CheckList::findOrFail($id);
        if ($checkList->delete()) {
            return $this->getResponse('success.destroy');
        } else {
            return $this->getResponse('error.destroy');
        }
    }
}
