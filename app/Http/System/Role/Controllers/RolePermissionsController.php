<?php

namespace App\Http\System\Role\Controllers;

use App\Domain\System\Permission\Permission;
use App\Domain\System\Role\Role;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;
use Sentinel;

class RolePermissionsController extends Controller
{
    public function index($id)
    {
        $role = Role::find($id);
        $permissions = Permission::get();
        return view('system.role.permissions.index',compact(['role','permissions']));
    }

    public function update(Request $request,$id)
    {
        $role = Role::find($id);
        $role->permissions = [];
        $role->save();
        $sentinelRole = Sentinel::findRoleBySlug($role->slug);
        $permissions = Permission::get();
        foreach ($permissions as $permission) {
            foreach (explode(',',$permission->list) as $p ) {
                $perm = '';
                $perm = $permission->slug.".".$p;
                if(!isset($request->perms)){
                    $sentinelRole->addPermission($perm,false);
                } else {

                    if(in_array($perm,$request->perms)) {
                        $sentinelRole->addPermission($perm);
                    }else{
                        $sentinelRole->addPermission($perm,false);
                    }
                }
            }
        }
        if ($sentinelRole->save()) {
            return response()->json(['success','Se han agregado los permisos'],200);
        } else {
            return response()->json(['error' => 'No pudieron ser asignados los permisos'],401);
        }

    }
}
