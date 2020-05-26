<?php

namespace App\Http\System\Menu\Controllers;

use App\Domain\System\Menu\Menu;
use App\Http\System\DataTable\DataTableAbstract;
use Sentinel;

class MenuDatatableController extends DataTableAbstract
{
	public function getRecords ()
	{
		return  Menu::with('parent')->get();
	}

	public function getRecord($record)
	{
		return [
            ($record->icon != '')?'<i class="fas fa-'.$record->icon.'"></i>' : '-',
			$record->name,
			$record->route,
			$record->position,
			optional($record->parent)->name,
			$this->getOptionButtons($record->id)
		];
	}

    public function getOptionButtons($id)
    {
        if (Sentinel::getUser()->hasAnyAccess(['menus.update','menus.delete'])) {
            return  makeGroupedLinks([
                makeEditButton($id,'',true,true),
                makeDeleteButton("Realmente desea eliminar el menu?",$id,"'reload'",'',true),
            ]);
        } else{
            return '-';
        }
    }
}
