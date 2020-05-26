<?php

namespace App\Http\Inspection\CheckList\Control\Controllers;


use App\Domain\Inspection\CheckList\Control\CheckListControl;
use App\Http\System\DataTable\DataTableAbstract;

class CheckListControlDatatableController extends DataTableAbstract
{
    public $entity = 'check-list-controls';

    public function getRecords()
    {
        return CheckListControl::where('sub_module_id',$this->filter)->get();
    }

    public function getRecord($record)
    {
        return [
            $record->name,
            $record->type,
            ($record->values != '')? implode('<br>',explode(';',$record->values)) : '',
            $record->metric ?? '',
            ($record->is_required == 1)? 'Si':'No',
            $this->getOptionButtons($record->id)
        ];
    }
}
