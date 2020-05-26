<?php

namespace App\Http\WaterManagement\Admin\Device\Sensor\Disposition\Controllers;

use App\Domain\WaterManagement\Device\Sensor\Disposition\Line\DispositionLine;
use App\Domain\WaterManagement\Device\Sensor\Disposition\SensorDisposition;
use Illuminate\Http\Request;
use App\app\Controllers\Controller;

class DispositionLinesController extends Controller
{
    public function index($disposition_id)
    {
        $disposition = SensorDisposition::with('lines')->find($disposition_id);
        return view('water-management.admin.device.sensor.disposition.index',compact('disposition'));
    }

    public function store(Request $request,$disposition_id)
    {
        $toInsert = array();
        $i = 0;
        SensorDisposition::find($disposition_id)->lines()->delete();
        foreach($request->color as $color) {
            if($request->value[$i] != ''  && $request->text[$i] != '') {
                array_push($toInsert,[
                    'sensor_disposition_id' => $disposition_id,
                    'color' => $color,
                    'chart' => $request->chart[$i],
                    'value' => $request->value[$i],
                    'text' => $request->text[$i],
                ]);
            }
            $i++;
        }
        DispositionLine::insert($toInsert);
        return response()->json(['success' => 'Lineas Creadas']);
    }

    public function deleteLine($line_id)
    {
        DispositionLine::destroy($line_id);
    }

    public function addLine()
    {
        return view('water-management.admin.device.sensor.disposition.newLine');

    }
}
