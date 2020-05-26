<?php

namespace App\Http\System\Permission\Controllers;

use App\Domain\System\Permission\Permission;
use App\Http\System\DataTable\DataTableAbstract;
use Sentinel;

class PermissionDatatableController extends DataTableAbstract
{

	public function getRecords()
	{
		return Permission::get();
	}

	public function getRecord($record)
	{
		return [
			$record->slug,
			implode('<br>',explode(',',$record->list)),
			$this->getOptionButtons($record->id)
		];
	}

    public function getOptionButtons($id)
    {
        if (Sentinel::getUser()->hasAnyAccess(['permissions.update','permissions.delete'])) {
            return makeGroupedLinks([
                makeEditButton($id,'',true,true),
                makeDeleteButton("Realmente desea eliminar el Permiso?",$id,"'reload'",'',true)
            ]);
        } else {
            return '-';
        }
    }
}
