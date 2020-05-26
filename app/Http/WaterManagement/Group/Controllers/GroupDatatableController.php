<?php

namespace App\Http\WaterManagement\Group\Controllers;

use App\Domain\WaterManagement\Group\Group;
use App\Http\System\DataTable\DataTableAbstract;

class GroupDatatableController extends DataTableAbstract
{
    public $entity = 'groups';

    public function getRecords()
    {
        return Group::get();
    }

    public function getRecord($record)
    {
        return [
            $record->name,
            $this->getOptionButtons($record->id)
        ];
    }
    
}
