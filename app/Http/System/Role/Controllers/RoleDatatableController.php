<?php

namespace App\Http\System\Role\Controllers;

use App\Domain\System\Role\Role;
use App\Http\System\DataTable\DataTableAbstract;
use Sentinel;

class RoleDatatableController extends DataTableAbstract
{
    public function getRecords()
	{
		return Role::get();
	}

	public function getRecord($record)
	{
		return [
			$record->slug,
			$record->name,
			$this->getOptionButtons($record->id)
		];
	}


    public function getOptionButtons($id)
    {
        $user = Sentinel::getUser();
        if ($user->hasAnyAccess(['roles.update','roles.delete','roles.permissions'])) {
            $buttons = array();
            $buttons = [
                makeEditButton($id,'',true,true),
                makeDeleteButton("Realmente desea eliminar el Role?",$id,"'reload'",'',true)
            ];

            if($user->hasAccess('roles.permissions')) {
                array_push(
                    $buttons,
                    makeRemoteLink('/rolePermissions/'.$id,'Permisos','fa-th-list','','',true)
                );
            }
            return  makeGroupedLinks(
                $buttons
            );
        } else {
            return '-';
        }
    }
}
