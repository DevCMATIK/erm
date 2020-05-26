<?php

namespace App\Http\Inspection\CheckList\Module\Sub\Controllers;


use App\Domain\Inspection\CheckList\Module\Sub\CheckListSubModule;
use App\Http\System\DataTable\DataTableAbstract;

class CheckListSubModuleDatatableController extends DataTableAbstract
{
    public $entity = 'check-list-sub-modules';

    public function getRecords()
    {
        return CheckListSubModule::where('module_id',$this->filter)->withCount('controls')->get();
    }

    public function getRecord($record)
    {
        return [
            $record->name,
            $record->columns,
            makeGroupedLinks(array_merge(
                $this->getDefaultOptions($record->id),
                [
                    makeLink("/check-list-controls?sub_module_id={$record->id}","Controles ({$record->controls_count})",'fa-check-square','btn-primary','btn-md','true'),
                ]
            ))
        ];
    }
}
