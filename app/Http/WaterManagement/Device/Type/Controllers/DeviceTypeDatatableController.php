<?php

namespace App\Http\WaterManagement\Device\Type\Controllers;

use App\Domain\WaterManagement\Device\Type\DeviceType;
use App\Http\System\DataTable\DataTableAbstract;

class DeviceTypeDatatableController extends DataTableAbstract
{
    public $entity = 'device-types';

    public function getRecords()
    {
        return DeviceType::get();
    }

    public function getRecord($record)
    {
        return [
            $record->name,
            $record->model,
            $record->brand,
            $this->getOptionButtons($record->id)
        ];
    }
}
