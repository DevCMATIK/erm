<?php

namespace App\Http\System\Role\Controllers;

use App\Domain\System\Role\Role;
use App\Http\System\Role\Requests\StoreRoleRequest;
use App\Http\System\Role\Requests\UpdateRoleRequest;
use App\App\Controllers\Controller;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('system.role.index');
    }
	public function create()
	{
		return view('system.role.create');
	}


	public function store(StoreRoleRequest $request)
	{
		if (Role::create($request->all())) {
            return $this->getResponse('success.store');
		}else {
			return $this->getResponse('error.store');
		}
	}

    public function edit($id)
	{
		$role = Role::find($id);
		return view('system.role.edit',compact('role'));
	}

	public function update(UpdateRoleRequest $request, $id)
	{
		if (Role::slugExists($request->slug,$id)) {
			return response()->json(['errors' => ['slug' => 'Ya Existe un Role con ese Slug.']],422);
		} else {
		    if (Role::find($id)->update($request->all())) {
                return $this->getResponse('success.update');
			} else {
				return $this->getResponse('error.update');
			}
		}
	}

	public function destroy($id)
	{
		$record = Role::find($id);
		if ($record->destroyRelationships()) {
			if (Role::destroy($id)) {
                return $this->getResponse('success.destroy');
			} else {
				return $this->getResponse('error.destroy');
			}
		} else {
			return response()->json(['error' => 'No se pueden eliminar sus relaciones'],401);
		}
	}
}
