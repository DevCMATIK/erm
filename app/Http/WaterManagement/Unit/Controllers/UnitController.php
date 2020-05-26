<?php

namespace App\Http\WaterManagement\Unit\Controllers;

use App\App\Controllers\Controller;
use App\Domain\WaterManagement\Unit\Unit;
use App\Http\WaterManagement\Unit\Requests\UnitRequest;

class UnitController extends Controller
{
    public function index()
    {
        return view('water-management.unit.index');
    }

    public function create()
    {
        return view('water-management.unit.create');
    }

    public function store(UnitRequest $request)
    {
        if (Unit::create($request->all())) {
            return $this->getResponse('success.store');
        } else {
            return $this->getResponse('error.store');
        }
    }

    public function edit($id)
    {
        $unit = Unit::findOrFail($id);
        return view('water-management.unit.edit',compact('unit'));
    }

    public function update(UnitRequest $request,$id)
    {
        $unit = Unit::findOrFail($id);
        if ($unit->update($request->all())) {
            return $this->getResponse('success.update');
        } else {
            return $this->getResponse('error.update');
        }
    }

    public function destroy($id)
    {
        $unit = Unit::findOrFail($id);
        if ($unit->delete()) {
            return $this->getResponse('success.destroy');
        } else {
            return $this->getResponse('error.destroy');
        }
    }
}
