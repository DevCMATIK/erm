<?php

namespace App\Http\System\Import\Import\Controllers;

use App\Domain\System\Import\Import;
use App\Domain\System\Role\Role;
use App\Http\System\Import\Import\Requests\ImportRequest;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;

class ImportController extends Controller
{

    public function index()
    {
        return view('system.import.index');
    }

    public function create()
    {
        $roles = Role::get();
        return view('system.import.create',compact('roles'));
    }


    public function store(ImportRequest $request)
    {
        $roles = $request->roles;
        if (!$roles) {
            return response()->json(['error' => 'Debe seleccionar un Role'],401);
        } else {
            if (count($request->fields) == 0) {
                return response()->json(['error','Debe ingresar el nombre de almenos una columna'],401);
            } else {
                if ($import = Import::create(
                        array_merge(
                            $request->only(['name','description','offset']),
                            [
                                'ignore_header' => (isset($request->ignore_header))?1:0,
                                'slug' => str_slug($request->name),
                                'fields' => implode(',',$request->fields)
                            ]
                        )
                )) {
                    $import->attachRoles($roles);
                    return $this->getResponse('success.store');
                } else {
                    return $this->getResponse('error.store');
                }
            }
        }
    }

    public function edit($id)
    {
        $import = Import::with('roles')->findOrFail($id);
        $roles = Role::get();
        $fields = $import->getFieldsArray();
        return view('system.import.edit',compact(['roles','import','fields']));
    }

    public function update(Request $request, $id)
    {
        $roles = $request->roles;
        $import = Import::findOrFail($id);
        if (!$roles) {
            return response()->json(['error' => 'Debe seleccionar un Role'],401);
        } else {
            if (count($request->fields) == 0) {
                return response()->json(['error','Debe ingresar el nombre de almenos una columna'],401);
            } else {

                if ($import->update(
                    array_merge(
                        $request->only(['name','description','offset']),
                        [
                            'ignore_header' => (isset($request->ignore_header))?1:0,
                            'slug' => str_slug($request->name),
                            'fields' => implode(',',$request->fields)
                        ]
                    )
                )) {
                    $import->detachAllRoles();
                    $import->attachRoles($roles);
                    return $this->getResponse('success.update');
                } else {
                    return $this->getResponse('error.update');
                }
            }
        }
    }

    public function destroy($id)
    {
        $import = Import::findOrFail($id);
        if ($import->detachAllRoles()) {
            $import->files()->delete();
            if ($import->delete()) {
                return $this->getResponse('success.destroy');
            }else {
                return $this->getResponse('error.destroy');
            }
        } else {
            return $this->getResponse('error.destroy');
        }
    }
}
