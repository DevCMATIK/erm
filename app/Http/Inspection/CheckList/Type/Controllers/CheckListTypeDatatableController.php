<?php

namespace App\Http\Inspection\CheckList\Type\Controllers;

use App\Domain\Inspection\CheckList\Type\CheckListType;
use App\Http\System\DataTable\DataTableAbstract;

class CheckListTypeDatatableController extends DataTableAbstract
{
    public $entity = 'check-list-types';

    public function getRecords()
    {
        return CheckListType::get();
    }

    public function getRecord($record)
    {
        return [
            $record->name,
            $this->getOptionButtons($record->id)
        ];
    }
}
