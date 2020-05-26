<?php

namespace App\Http\System\User\Controllers;

use App\Domain\System\Permission\Permission;
use App\Domain\System\User\User;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;
use Sentinel;

class UserPermissionsController extends Controller
{
    public function index($id)
    {
        $user = User::find($id);
        $permissions = Permission::get();
        return view('system.user.permissions.index',compact(['user','permissions']));
    }

    public function update(Request $request,$id)
    {
        $user = User::find($id);
        $user->permissions = [];
        $user->save();
        $sentinelUser = Sentinel::findById($user->id);
        $permissions = Permission::get();
        foreach ($permissions as $permission) {
            foreach (explode(',',$permission->list) as $p ) {
                $perm = '';
                $perm = $permission->slug.".".$p;
                if(!isset($request->perms)){
                    $sentinelUser->addPermission($perm,false);
                } else {
                    if (in_array($perm,$request->perms)) {
                        $sentinelUser->addPermission($perm);
                    } else {
                        $sentinelUser->addPermission($perm,false);
                    }
                }
            }
        }
        if ($sentinelUser->save()) {
            return response()->json(['success','Se han agregado los permisos'],200);
        } else {
            return response()->json(['error' => 'No pudieron ser asignados los permisos'],401);
        }

    }
}
