<?php

namespace App\Http\WaterManagement\Scale\Controllers;

use App\Domain\WaterManagement\Scale\Scale;
use App\Http\WaterManagement\Scale\Requests\ScaleRequest;
use App\App\Controllers\Controller;

class ScaleController extends Controller
{
    public function index()
    {
        return view('water-management.scale.index');
    }

    public function create()
    {
        return view('water-management.scale.create');
    }

    public function store(ScaleRequest $request)
    {
        if (Scale::create($request->all())) {
            return $this->getResponse('success.store');
        } else {
            return $this->getResponse('error.store');
        }
    }

    public function edit($id)
    {
        $scale = Scale::findOrFail($id);
        return view('water-management.scale.edit',compact('scale'));
    }

    public function update(ScaleRequest $request, $id)
    {
        $scale = Scale::findOrFail($id);
        if ($scale->update($request->all())) {
            return $this->getResponse('success.update');
        } else {
            return $this->getResponse('error.update');
        }
    }

    public function destroy($id)
    {
        $scale = Scale::findOrFail($id);
        if ($scale->delete()) {
            return $this->getResponse('success.destroy');
        } else {
            return $this->getResponse('error.destroy');
        }
    }
}
