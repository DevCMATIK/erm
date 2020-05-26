<?php

namespace App\Http\User\Settings\Controllers;

use App\Domain\System\File\File;
use App\Domain\System\User\User;
use App\Http\User\Settings\Requests\UpdateUserRequest;
use App\App\Controllers\Controller;
use Sentinel;

class AccountGeneralController extends Controller
{
    public function index()
    {
        $user = Sentinel::getUser();
        $avatar = File::findByTableAndId('users',$user->id);
        return view('user.settings.account-general',compact(['avatar','user']));
    }

    public function update(UpdateUserRequest $request)
    {
        $user = Sentinel::getUser();
        if (!User::where('email',$request->email)->where('id','<>',$user->id)->first()) {
            if ($user->update($request->all())) {
                return response()->json(['success' => 'Se ha actualizado su información correctamente']);
            } else {
                return response()->json(['error' => 'No se pudo actualizar su información'],401);
            }
        } else {
            return response()->json(['error' => 'Ya existe un usuario registrado con ese Email.'],401);
        }
    }
}
