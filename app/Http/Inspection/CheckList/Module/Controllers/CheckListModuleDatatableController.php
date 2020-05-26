<?php

namespace App\Http\Inspection\CheckList\Module\Controllers;



use App\Domain\Inspection\CheckList\Module\CheckListModule;
use App\Http\System\DataTable\DataTableAbstract;

class CheckListModuleDatatableController extends DataTableAbstract
{
    public $entity = 'check-list-modules';

    public function getRecords()
    {
        return CheckListModule::where('check_list_id',$this->filter)->withCount('sub_modules')->orderBy('position')->get();
    }

    public function getRecord($record)
    {
        return [
            $record->name,
            $record->position,
            makeGroupedLinks(array_merge(
                $this->getDefaultOptions($record->id),
                [
                    makeLink("/check-list-sub-modules?module={$record->id}","Sub Modulos ({$record->sub_modules_count})",'fa-check-square','btn-primary','btn-md','true'),
                ]
            ))
        ];
    }
}
