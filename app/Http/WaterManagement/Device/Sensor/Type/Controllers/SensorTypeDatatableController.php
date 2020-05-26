<?php

namespace App\Http\WaterManagement\Device\Sensor\Type\Controllers;

use App\Domain\WaterManagement\Device\Sensor\Type\SensorType;
use App\Http\System\DataTable\DataTableAbstract;

class SensorTypeDatatableController extends DataTableAbstract
{
    public $entity = 'sensor-types';

    public function getRecords()
    {
        return SensorType::withCount('interpreters')->get();
    }

    public function getRecord($record)
    {
        return [
            $record->name,
            'Cada '.$record->interval.' minuto(s)',
            $this->getOptionButtons($record)
        ];
    }

    public function getOptionButtons($record)
    {
        return makeGroupedLinks(array_merge(
            $this->getDefaultOptions($record->id),
            [
                makeLink('/interpreters?type_id='.$record->id,'Interpretadores ('.$record->interpreters_count.')','fa-book','btn-secondary','btn-md',true)
            ]
        ));
    }
}
