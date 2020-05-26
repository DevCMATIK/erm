<?php

namespace App\Http\Inspection\CheckList\Type\Controllers;

use App\App\Controllers\Controller;
use App\Domain\Inspection\CheckList\Type\CheckListType;
use App\Http\Inspection\CheckList\Type\Requests\CheckListTypeRequest;
use Illuminate\Support\Str;

class CheckListTypeController extends Controller
{
    public function index()
    {
        return view('inspection.check-list.type.index');
    }

    public function create()
    {
        return view('inspection.check-list.type.create');
    }

    public function store(CheckListTypeRequest $request)
    {
        if (CheckListType::findBySlug(Str::slug($request->name))) {
            return $this->slugError();
        } else {
            if (CheckListType::create([
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
        $type = CheckListType::findOrFail($id);
        return view('inspection.check-list.type.edit',compact('type'));
    }

    public function update(CheckListTypeRequest $request,$id)
    {
        $type = CheckListType::findOrFail($id);
        if(CheckListType::slugExists(Str::slug($request->name),$id)) {
            return $this->slugError();
        } else {
            if ($type->update([
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
        $type = CheckListType::findOrFail($id);
        if ($type->delete()) {
            return $this->getResponse('success.destroy');
        } else {
            return $this->getResponse('error.destroy');
        }
    }
}
