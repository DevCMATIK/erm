<?php

namespace App\Http\Inspection\CheckList\Controllers;

use App\Domain\Inspection\CheckList\CheckList;
use App\Http\System\DataTable\DataTableAbstract;

class CheckListDatatableController extends DataTableAbstract
{
    public $entity = 'check-lists';

    public function getRecords()
    {
        return CheckList::with('check_point_type')->withCount('modules')->get();
    }

    public function getRecord($record)
    {
        return [
            $record->name,
            $record->check_point_type->name,
            makeGroupedLinks(array_merge(
                $this->getDefaultOptions($record->id),
                [
                    makeLink("/check-list-modules?check_list_id={$record->id}","Modulos ({$record->modules_count})",'fa-check-square','btn-primary','btn-md','true'),
                    makeLink("/check-list-preview/".$record->slug,"Vista Previa",'fa-eye','btn-primary','btn-md','true')
                ]
            ))
        ];
    }
}
