<?php

namespace App\Http\Inspection\CheckList\Module\Controllers;

use App\App\Controllers\Controller;
use App\Domain\Inspection\CheckList\CheckList;
use App\Domain\Inspection\CheckList\Module\CheckListModule;
use App\Http\Inspection\CheckList\Module\Requests\CheckListModuleRequest;
use Illuminate\Http\Request;

class CheckListModuleController extends Controller
{
    public function index(Request $request)
    {
        $checkList = CheckList::find($request->check_list_id);
        return view('inspection.check-list.module.index',compact('checkList'));
    }

    public function create(Request $request)
    {
        $checkList = CheckList::find($request->check_list_id);
        return view('inspection.check-list.module.create',compact('checkList'));
    }

    public function store(CheckListModuleRequest $request)
    {
        if (CheckListModule::create(array_merge([
            'position' => 0
        ], $request->all()))) {
            return $this->getResponse('success.store');
        } else {
            return $this->getResponse('error.store');
        }
    }

    public function edit($id)
    {
        $module = CheckListModule::findOrFail($id);
        return view('inspection.check-list.module.edit',compact('module'));
    }

    public function update(CheckListModuleRequest $request,$id)
    {
        $module = CheckListModule::findOrFail($id);
            if ($module->update(array_merge([
                'position' => 0
            ], $request->all()))) {
                return $this->getResponse('success.update');
            } else {
                return $this->getResponse('error.update');
            }

    }

    public function destroy($id)
    {
        $module = CheckListModule::findOrFail($id);
        if ($module->delete()) {
            return $this->getResponse('success.destroy');
        } else {
            return $this->getResponse('error.destroy');
        }
    }
}
