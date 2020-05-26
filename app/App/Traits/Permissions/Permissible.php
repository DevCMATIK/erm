<?php

namespace App\App\Traits\Permissions;

use App\Domain\System\Permission\Permission;

trait Permissible
{
    public function handlePermissions($slug)
    {
        $oldPermissions = collect(array_keys($this->permissions))->filter(function($item) use ($slug){
            return stristr($item,$slug);
        })->toArray();
        $permissions = Permission::getPermissionsArray($slug);
        $deleted = array_diff($oldPermissions,$permissions);
        $added = array_diff($permissions,$oldPermissions);
        if (count($deleted) > 0) {
           foreach ($deleted as $d) {
                $this->removePermission($d);
           }
        }
        if (count($added) > 0) {
           foreach ($added as $a) {
               $this->addPermission($a,false);
           }
        }
        $this->save();
    }
}
