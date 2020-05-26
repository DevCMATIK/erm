<?php

namespace App\Http\WaterManagement\Device\Sensor\Alarm\Controllers;

use App\Domain\WaterManagement\Device\Sensor\Alarm\SensorAlarmLog;
use Carbon\Carbon;
use App\App\Controllers\Controller;
use Sentinel;

class AccuseAlarmController extends Controller
{
    public function __invoke($id)
    {
        $sensor_alarm = SensorAlarmLog::find($id);
        $sensor_alarm->update([
            'accused' => 0,
            'accused_by' => null,
            'accused_at' => null,
            'last_email' => null
        ]);

        $sensor_alarm->unaccused_alarms()->create([
            'user_id' => Sentinel::getUser()->id,
            'date' => Carbon::now()->toDateTimeString()
        ]);

        return redirect()->back();
    }
}
