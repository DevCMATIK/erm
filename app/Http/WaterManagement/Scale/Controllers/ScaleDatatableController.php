<?php

namespace App\Http\WaterManagement\Scale\Controllers;

use App\Domain\WaterManagement\Scale\Scale;
use App\Http\System\DataTable\DataTableAbstract;

class ScaleDatatableController extends DataTableAbstract
{
    public $entity = 'scales';

    public function getRecord($record)
    {
        return [
            $record->name,
            $record->min,
            $record->max,
            $record->precision,
            $this->getOptionButtons($record->id)
        ];
    }

    public function getRecords()
    {
        return Scale::get();
    }
}
