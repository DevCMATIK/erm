<?php

namespace App\Http\WaterManagement\Admin\Device\Sensor\Behavior\Controllers;

use App\Domain\WaterManagement\Device\Sensor\Sensor;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;

class CreateAverageForSensorController extends Controller
{
    public function __invoke($sensor_id,$average)
    {
        $sensor = Sensor::find($sensor_id);

        $sensor->average()->create(['last_average' => $average]);

        return response()->json(['success' => 'Media creada para sensor.']);
    }
}
