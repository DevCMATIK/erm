<?php

namespace App\Http\Client\CheckPoint\Grid\Controllers;

use App\Domain\Client\CheckPoint\CheckPoint;
use App\Domain\Client\CheckPoint\Grid\CheckPointGrid;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;

class CheckPointGridController extends Controller
{
    public function index($check_point_id)
    {
        $checkPoint = CheckPoint::with(['grids.sensor','devices.analogous_sensors'])->find($check_point_id);
        return view('client.check-point.grid.index', compact('checkPoint'));
    }

    public function serialize(Request $request, $id)
    {
        $column1 = json_decode($request->column1,true);
        $column2 = json_decode($request->column2,true);
        $column3 = json_decode($request->column3,true);
        $checkPoint = CheckPoint::find($id);
        $checkPoint->grids()->delete();
        $this->saveColumn(1,$column1,$id);
        $this->saveColumn(2,$column2,$id);
        $this->saveColumn(3,$column3,$id);
        return response()->json(['success' => 'Sensores serializados correctamente']);
    }

    protected function saveColumn($column,$sensors,$checkPoint)
    {
        $i = 1;
        $toInsert = array();
        foreach($sensors as $sensor)
        {
            if(stristr($sensor['id'],'blank_')) {

                $s = null;
            } else {
                $s = $sensor['id'];
            }
            array_push($toInsert,[
                'check_point_id' => $checkPoint,
                'column' => $column,
                'sensor_id' => $s,
                'row' => $i
            ]);
            $i++;
        }
        CheckPointGrid::insert($toInsert);
    }

    public function reset($id)
    {
        CheckPointGrid::where('check_point_id',$id)->delete();

        return response()->json(['success' => 'Reset completado']);
    }
}
