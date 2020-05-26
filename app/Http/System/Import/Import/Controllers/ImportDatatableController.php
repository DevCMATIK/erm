<?php

namespace App\Http\System\Import\Import\Controllers;

use App\Domain\System\Import\Import;
use App\Http\System\DataTable\DataTableAbstract;
use Sentinel;

class ImportDatatableController extends DataTableAbstract
{
	public function getRecords()
	{
		return Import::get();
	}

	public function getRecord($record)
	{
		return [
			$record->name,
			$record->slug,
			$record->description,
			implode(',',$record->entityRolesAsArray()),
			$this->getOptionButtons($record->id)
		];
	}

    public function getOptionButtons($id)
    {
        $user = Sentinel::getUser();
        $buttons = array();
        if (Sentinel::getUser()->hasAnyAccess(['imports.update','imports.delete','imports.serialize'])) {
            $buttons = [
                makeEditButton($id,'',true,true),
                makeDeleteButton("Realmente desea eliminar el módulo de importación?",$id,"'reload'",'',true),
            ];

            if ($user->hasAccess('imports.serialize')) {
                array_push(
                    $buttons,
                    makeRemoteLink('/serializeImport/'.$id,'Serializar','fa-list-ol','','',true)
                );
            }
            return makeGroupedLinks($buttons);
        } else {
            return '-';
        }


    }
}
