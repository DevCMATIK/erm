<?php

namespace App\Http\Data\Controllers;

use App\Domain\WaterManagement\Device\Sensor\Sensor;
use App\Http\Data\Events\BackupedAverages;
use App\Http\Data\Events\BackupSensorAverages;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;

class BackupSensorAveragesController extends Controller
{
    public function __invoke($sensor_id)
    {
        $sensor = Sensor::with('analogous_reports')->withCount('analogous_reports')->find($sensor_id);

        if($sensor->analogous_reports_count > 0) {
            event(new BackupSensorAverages($sensor));
            event(new BackupedAverages($sensor_id));        }

        return back()->with('success','Se ha creado el proceso de respaldo de medias');

    }
}
