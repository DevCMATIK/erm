<?php

namespace App\Http\WaterManagement\Unit\Controllers;

use App\Domain\WaterManagement\Unit\Unit;
use App\Http\System\DataTable\DataTableAbstract;

class UnitDatatableController extends DataTableAbstract
{
    public $entity = 'units';

    public function getRecords()
    {
        return Unit::get();
    }

    public function getRecord($record)
    {
        return [
            $record->name,
            $this->getOptionButtons($record->id)
        ];
    }
}
