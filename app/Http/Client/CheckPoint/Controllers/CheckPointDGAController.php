<?php

namespace App\Http\Client\CheckPoint\Controllers;

use App\Domain\Client\CheckPoint\CheckPoint;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;

class CheckPointDGAController extends Controller
{
    public function store(Request $request, $id)
    {
        $checkPoint = CheckPoint::findOrFail($id);
        $checkPoint->dga_report = $request->dga_report;
        $checkPoint->work_code = $request->work_code;
        $checkPoint->save();

        return response()->json(['success' => 'Datos guardados correctamente']);
    }
}
