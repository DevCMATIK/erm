<?php

namespace App\Http\Inspection\CheckList\Module\Sub\Controllers;

use App\Domain\Inspection\CheckList\Module\CheckListModule;
use App\Domain\Inspection\CheckList\Module\Sub\CheckListSubModule;
use App\Http\Inspection\CheckList\Module\Sub\Requests\CheckListSubModuleRequest;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;

class CheckListSubModuleController extends Controller
{
    public function index(Request $request)
    {
        $module = CheckListModule::find($request->module);
        return view('inspection.check-list.module.sub.index',compact('module'));
    }

    public function create(Request $request)
    {
        $module = CheckListModule::find($request->module);
        return view('inspection.check-list.module.sub.create',compact('module'));
    }

    public function store(CheckListSubModuleRequest $request)
    {
        if (CheckListSubModule::create($request->all())) {
            return $this->getResponse('success.store');
        } else {
            return $this->getResponse('error.store');
        }
    }

    public function edit($id)
    {
        $sub = CheckListSubModule::findOrFail($id);
        return view('inspection.check-list.module.sub.edit',compact('sub'));
    }

    public function update(CheckListSubModuleRequest $request,$id)
    {
        $module = CheckListSubModule::findOrFail($id);
        if ($module->update($request->all())) {
            return $this->getResponse('success.update');
        } else {
            return $this->getResponse('error.update');
        }

    }

    public function destroy($id)
    {
        $module = CheckListSubModule::findOrFail($id);
        if ($module->delete()) {
            return $this->getResponse('success.destroy');
        } else {
            return $this->getResponse('error.destroy');
        }
    }
}
