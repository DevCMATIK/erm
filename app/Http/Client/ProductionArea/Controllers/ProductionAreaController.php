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
        if ($new = ProductionArea::create($request->all())) {
            addChangeLog('Area de Producción Creada','production_areas',null,convertColumns($new));

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
        $productionArea = ProductionArea::findOrFail($id);
        $old = convertColumns($productionArea);
        if ($productionArea->update($request->all())) {
            addChangeLog('Area de Producción Modificada','production_areas',$old,convertColumns($productionArea));

            return $this->getResponse('success.update');
        } else {
            return $this->getResponse('error.update');
        }
    }

    public function destroy($id)
    {
        $productionArea = ProductionArea::findOrFail($id);
        if ($productionArea->delete()) {
            addChangeLog('Area de Producción eliminada','production_areas',$productionArea);

            return $this->getResponse('success.destroy');
        } else {
            return $this->getResponse('error.destroy');
        }
    }
}
