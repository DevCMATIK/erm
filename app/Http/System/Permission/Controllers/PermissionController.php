<?php

namespace App\Http\System\Permission\Controllers;

use App\Domain\System\Permission\Permission;
use App\Domain\System\Role\Role;
use App\Http\System\Permission\Requests\StorePermissionRequest;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;
use Sentinel;

class PermissionController extends Controller
{

    public function index()
    {
        return view('system.permission.index');
    }


    public function create()
    {
        return view('system.permission.create');
    }


    public function store(StorePermissionRequest $request)
    {
        if (Permission::create($request->all())) {
            $roles = Role::get();
            foreach ($roles as $role) {
                $role->handlePermissions($request->slug);
            }
            //addChangeLog('Permiso creado','permissions',null,convertColumns($permission));

            return $this->getResponse('success.store');
        } else {
            return $this->getResponse('error.store');
        }
    }

    public function edit($id)
    {
        $permission = Permission::find($id);
        return view('system.permission.edit',compact('permission'));
    }

    public function update(Request $request, $id)
    {
        if (!Permission::slugExists($request->slug,$id)) {
            if ($permission = Permission::find($id)) {
                //$old = convertColumns($permission);
                if ($permission->update($request->all())) {
                    $roles = Role::get();
                    foreach ($roles as $role) {
                        $role->handlePermissions($request->slug);
                    }
                    //addChangeLog('Permiso Modificado','permissions',$old,convertColumns($permission));

                    return $this->getResponse('success.update');
                } else {
                    return $this->getResponse('error.update');
                }
            } else {
                return response()->json(['error' => 'No existe el permiso indicado.'],401);
            }
        } else {
            return response()->json(['errors' => ['slug' =>'Existe otro permiso con ese nombre.']],422);
        }
    }


    public function destroy($id)
    {
        Permission::find($id);
        if ( Permission::destroy($id)) {
            //addChangeLog('Permiso Eliminado','permissions',convertColumns($permission));

            return $this->getResponse('success.destroy');
        } else {
            return $this->getResponse('error.destroy');
        }
    }
}
