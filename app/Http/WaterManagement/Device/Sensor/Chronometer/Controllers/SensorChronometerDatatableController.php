<?php

namespace App\Http\WaterManagement\Device\Sensor\Chronometer\Controllers;

use App\Domain\WaterManagement\Device\Sensor\Chronometer\SensorChronometer;
use App\Http\System\DataTable\DataTableAbstract;
use Illuminate\Http\Request;

class SensorChronometerDatatableController extends DataTableAbstract
{
    public $entity = 'sensor-chronometers';

    public function getRecords()
    {
        return SensorChronometer::withCount('trackings')->where('sensor_id',$this->filter)->get();
    }

    public function getRecord($record)
    {
        return [
            $record->equals_to,
            $record->trackings_count,
            $this->getOptionButtons($record->id)
        ];
    }


}
