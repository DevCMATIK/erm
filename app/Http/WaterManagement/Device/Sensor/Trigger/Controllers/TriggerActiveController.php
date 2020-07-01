<?php

namespace App\Http\WaterManagement\Device\Sensor\Trigger\Controllers;

use App\Domain\WaterManagement\Device\Sensor\Trigger\SensorTrigger;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;

class TriggerActiveController extends Controller
{
    public function __invoke(Request $request,$trigger,$active)
    {
        $t = SensorTrigger::find($trigger);
        $t->is_active = $active;
        $t->save();

        return redirect($request->url());
    }
}
