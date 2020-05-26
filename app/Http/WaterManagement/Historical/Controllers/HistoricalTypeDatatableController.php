<?php

namespace App\Http\WaterManagement\Historical\Controllers;


use App\Domain\WaterManagement\Historical\HistoricalType;
use App\Http\System\DataTable\DataTableAbstract;

class HistoricalTypeDatatableController extends DataTableAbstract
{
    public $entity = 'historical-types';

    public function getRecords()
    {
        return HistoricalType::get();
    }

    public function getRecord($record)
    {
        return [
            $record->internal_id,
            $record->name,
            $this->getOptionButtons($record->id)
        ];
    }
}
