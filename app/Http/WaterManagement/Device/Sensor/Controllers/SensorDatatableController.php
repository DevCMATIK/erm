<?php

namespace App\Http\WaterManagement\Device\Sensor\Controllers;

use App\Domain\WaterManagement\Device\Sensor\Sensor;
use App\Http\System\DataTable\DataTableAbstract;

class SensorDatatableController extends DataTableAbstract
{
    public $entity = 'sensors';

    public function getRecords()
    {
        return Sensor::with([
            'address',
            'type'
        ])->where('device_id',$this->filter)->get();
    }

    public function getRecord($record)
    {
        return [
            $record->name ?? 'No asignado',
            $record->type->name,

            $record->address->name,
            $record->address_number,

            $this->getOptionButtons($record->id)
        ];
    }

    public function getOptionButtons($id)
    {
        return makeGroupedLinks(
            array_merge(
                $this->getDefaultOptions($id),
                [
                    makeLink('/sensor-triggers?sensor_id='.$id,'Desencadenadores','fa-cogs','btn-secondary','btn-sm',true),
                    makeLink('/sensor-alarms?sensor_id='.$id,'Alarmas','fa-exclamation-triangle','btn-secondary','btn-sm',true)
                ]
            )
        );
    }
}
