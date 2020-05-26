<?php

namespace App\Http\Client\Zone\Sub\Controllers;


use App\Domain\Client\Zone\Sub\SubZone;
use App\Domain\Client\Zone\Zone;
use App\Http\System\DataTable\DataTableAbstract;

class SubZoneDatatableController extends DataTableAbstract
{
    public $entity = 'sub-zones';


    public function getRecords()
    {
        $zone = Zone::findBySlug($this->filter);
        return SubZone::with('zone')->where('zone_id',$zone->id)->get();
    }

    public function getRecord($record)
    {
        return [
            $record->name,
            $record->zone->name,
            $this->getOptionButtons($record->id)
        ];
    }
}
