<?php

namespace App\Http\System\User\Controllers;

use App\Domain\System\Role\Role;
use App\Domain\System\User\User;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;

class UserRolesController extends Controller
{
    public function index($id)
    {
        $user = User::find($id);
        $roles = Role::get();
        return view('system.user.role.index',compact(['user','roles']));
    }

    public function storeRoles(Request $request, $id)
    {
        if ($request->roles) {
            $user = User::find($id);
            if ($user->detachAllRoles()) {
                $user->attachRoles($request->roles);
                return response()->json(['success' => 'Roles Asignados.'],200);
            }  else {
                return response()->json(['error' => 'No puede ser desvicunlado de los Roles.'],401);
            }
        } else {
            return response()->json(['error' => 'Debe seleccionar almenos 1 Role.']);
        }

    }
}
