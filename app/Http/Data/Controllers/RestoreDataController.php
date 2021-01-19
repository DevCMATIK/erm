<?php

namespace App\Http\Data\Controllers;

use App\Domain\WaterManagement\Device\Sensor\Sensor;
use App\Http\Data\Jobs\Restore\DeleteDataFromSensor;
use App\Http\Data\Jobs\Restore\RestoreDataForSensor;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;

class RestoreDataController extends Controller
{
    public function index()
    {
        return view('data.restore');
    }

    public function getSensorData(Request $request)
    {
        return Sensor::with(['device','address','type'])->find($request->sensor_id)->toArray();
    }

    public function deleteData(Request $request)
    {
        DeleteDataFromSensor::dispatch($request->sensor_id,$request->start_date,$request->end_date,$request->start_date)->onQueue('long-running-queue-low');

        return response()->json(['success' => "Se ha comenzado a eliminar la data correctamente"]);
    }

    public function beginRestore(Request $request)
    {
        RestoreDataForSensor::dispatch($request->sensor_id,$request->start_date,$request->end_date,$request->start_date)->onQueue('long-running-queue-low');
        return response()->json(['success' => "ha comenzado el proceso de restauración"]);
    }
}
