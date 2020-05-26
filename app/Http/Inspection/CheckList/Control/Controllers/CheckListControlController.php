<?php

namespace App\Http\Inspection\CheckList\Control\Controllers;

use App\Domain\Inspection\CheckList\Control\CheckListControl;
use App\Domain\Inspection\CheckList\Module\Sub\CheckListSubModule;
use App\Http\Inspection\CheckList\Control\Requests\CheckListControlRequest;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;

class CheckListControlController extends Controller
{
    public function index(Request $request)
    {
        $subModule = CheckListSubModule::find($request->sub_module_id);
        return view('inspection.check-list.control.index',compact('subModule'));
    }

    public function create(Request $request)
    {
        $subModule = CheckListSubModule::find($request->sub_module_id);
        return view('inspection.check-list.control.create',compact('subModule'));
    }

    public function store(CheckListControlRequest $request)
    {
        if (CheckListControl::create($request->all())) {
            return $this->getResponse('success.store');
        } else {
            return $this->getResponse('error.store');
        }
    }

    public function edit($id)
    {
        $control = CheckListControl::findOrFail($id);
        return view('inspection.check-list.control.edit',compact('control'));
    }

    public function update(CheckListControlRequest $request,$id)
    {
        $control = CheckListControl::findOrFail($id);
        if ($control->update($request->all())) {
            return $this->getResponse('success.update');
        } else {
            return $this->getResponse('error.update');
        }

    }

    public function destroy($id)
    {
        $control = CheckListControl::findOrFail($id);
        if ($control->delete()) {
            return $this->getResponse('success.destroy');
        } else {
            return $this->getResponse('error.destroy');
        }
    }
}
