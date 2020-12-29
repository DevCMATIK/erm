<?php

namespace App\Http\System\User\Controllers;

use App\Domain\System\Role\Role;
use App\Domain\System\User\User;
use App\Domain\WaterManagement\Group\Group;
use App\Http\Auth\Events\UserRegistered;
use App\Http\System\User\Requests\StoreUserRequest;
use App\Http\System\User\Requests\UpdateUserRequest;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;
use Sentinel;

class UserController extends Controller
{

    public function index()
    {
        return view('system.user.index');
    }

    public function create()
    {
        $roles = Role::get();
        $groups = Group::get();
        return view('system.user.create',compact('roles','groups'));
    }

    public function store(StoreUserRequest $request)
    {
        if ($record = Sentinel::registerAndActivate(array_merge($request->all(),[
            'password' => explode('@',$request->email)[0]
        ]))) {
            event(new UserRegistered($record));
            if($request->has('roles')) {
                $record->roles()->attach($request->roles);
            }
            if($request->has('groups')) {
                $record->groups()->sync($request->groups);
            }
            return $this->getResponse('success.store');
        } else {
            return $this->getResponse('error.store');
        }
    }

    public function edit($id)
    {
        $roles = Role::get();
        $groups = Group::get();
        $user = User::with('roles','groups')->findOrFail($id);
        return view('system.user.edit',compact('user','groups','roles'));
    }

    public function update(UpdateUserRequest $request, $id)
    {
        $record = User::find($id);
        $tryUser = User::where('email',$request->email)->first();
        if($tryUser && $tryUser->id != $id){
            return response()->json(['error' => 'El Email ya fue usado por otro usuario'],401);
        }else{
            $record->email = $request->email;
            $record->first_name = $request->first_name;
            $record->last_name = $request->last_name;
            $record->phone = $request->phone;

            if ($record->save()) {

                if($request->has('roles')) {

                    $record->roles()->sync($request->roles);
                }
                if($request->has('groups')) {
                    $record->groups()->sync($request->groups);
                }
                return $this->getResponse('success.update');
            }else{
                return $this->getResponse('error.update');
            }
        }
    }

    public function destroy($id)
    {
        if ($record = User::find($id)) {
            if ($record->destroyRelationships()) {
                if ($record->delete()) {
                    return $this->getResponse('success.destroy');
                } else {
                    return $this->getResponse('error.destroy');
                }
            } else {
                return response()->json(['error' => "No se pueden eliminar sus relaciones en base de datos."],401);
            }
        } else {
            return response()->json(['error' => "No existe el usuario."],401);
        }
    }
}
