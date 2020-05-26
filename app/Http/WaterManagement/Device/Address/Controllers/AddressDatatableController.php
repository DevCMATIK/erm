<?php

namespace App\Http\WaterManagement\Device\Address\Controllers;

use App\Domain\WaterManagement\Device\Address\Address;
use App\Http\System\DataTable\DataTableAbstract;
class AddressDatatableController extends DataTableAbstract
{
    public $entity = 'addresses';

    public function getRecords()
    {
        return Address::get();
    }

    public function getRecord($record)
    {
        return [
            $record->name,
            $record->register_type_id,
            ($record->configuration_type == 'scale')?'Escalas y Rangos':'On/Off',
            $this->getOptionButtons($record->id)
        ];
    }
}
