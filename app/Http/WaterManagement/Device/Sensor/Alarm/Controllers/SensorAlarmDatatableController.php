<?php

namespace App\Http\WaterManagement\Device\Sensor\Alarm\Controllers;

use App\Domain\WaterManagement\Device\Sensor\Alarm\SensorAlarm;
use App\Http\System\DataTable\DataTableAbstract;

class SensorAlarmDatatableController extends DataTableAbstract
{
    public $entity = 'sensor-alarms';

    public function getRecords()
    {
        return SensorAlarm::withCount('logs')->with(['user','last_log'])->where('sensor_id',$this->filter)->get();
    }

    public function getRecord($record)
    {
        return [
            $record->user->full_name,
            $record->range_min,
            $record->range_max,
            ($record->is_active === 1)? 'Activo' : 'Inactivo',
            ($record->send_email === 1)? 'Enviar' : 'No Enviar',
            $record->logs_count,
            optional($record->last_log->first())->start_date ?? 'No Ejecutada',
            $this->getOptionButtons($record->id)
        ];
    }

    public function getOptionButtons($id)
    {
        return makeGroupedLinks(
            array_merge(
                $this->getDefaultOptions($id),
                [
                    makeRemoteLink('/sensor-alarm-logs/'.$id,'Logs','fa-cogs','btn-secondary','btn-sm',true)

                ]
            )
        );
    }
}
