<?php

namespace App\Http\WaterManagement\Historical\Controllers;

use App\Domain\WaterManagement\Historical\HistoricalType;
use App\Http\WaterManagement\Historical\Requests\HistoricalTypeRequest;
use App\App\Controllers\Controller;
use Illuminate\Http\Request;

class HistoricalTypeController extends Controller
{
    public function index()
    {
        return view('water-management.historical-types.index');
    }

    public function create()
    {
        return view('water-management.historical-types.create');
    }

    public function store(HistoricalTypeRequest $request)
    {
        if (HistoricalType::create($request->all())) {
            return $this->getResponse('success.store');
        } else {
            return $this->getResponse('error.store');
        }
    }

    public function edit($id)
    {
        $historical = HistoricalType::findOrFail($id);
        return view('water-management.historical-types.edit',compact('historical'));
    }

    public function update(Request $request,$id)
    {
        $historical = HistoricalType::findOrFail($id);
        if ($historical->update($request->all())) {
            return $this->getResponse('success.update');
        } else {
            return $this->getResponse('error.update');
        }
    }

    public function destroy($id)
    {
        $historical = HistoricalType::findOrFail($id);
        if ($historical->delete()) {
            return $this->getResponse('success.destroy');
        } else {
            return $this->getResponse('error.destroy');
        }
    }
}
