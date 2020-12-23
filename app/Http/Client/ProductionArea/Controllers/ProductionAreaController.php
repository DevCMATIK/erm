<?php

namespace App\Http\Client\ProductionArea\Controllers;

use App\App\Controllers\Controller;
use App\Domain\Client\ProductionArea\ProductionArea;
use App\Http\Client\ProductionArea\Requests\ProductionAreaRequest;

class ProductionAreaController extends Controller
{
    public function index()
    {
        return view('client.production-area.index');
    }

    public function create()
    {
        return view('client.production-area.create');
    }

    public function store(ProductionAreaRequest $request)
    {
        if (ProductionArea::create($request->all())) {
            return $this->getResponse('success.store');
        } else {
            return $this->getResponse('error.store');
        }
    }

    public function edit($id)
    {
        $productionArea = ProductionArea::findOrFail($id);
        return view('client.production-area.edit', compact('productionArea'));
    }

    public function update(ProductionAreaRequest $request, $id)
    {
        $record = ProductionArea::findOrFail($id);
        if ($record->update($request->all())) {
            return $this->getResponse('success.update');
        } else {
            return $this->getResponse('error.update');
        }
    }

    public function destroy($id)
    {
        $record = ProductionArea::findOrFail($id);
        if ($record->delete()) {
            return $this->getResponse('success.destroy');
        } else {
            return $this->getResponse('error.destroy');
        }
    }
}
