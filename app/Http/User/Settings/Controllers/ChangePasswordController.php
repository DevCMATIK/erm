<?php

namespace App\Http\User\Settings\Controllers;

use App\Http\User\Settings\Requests\UpdatePasswordRequest;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;
use Sentinel;

class ChangePasswordController extends Controller
{
    public function index()
    {
        return view('user.settings.change-password');
    }

    public function changePassword(UpdatePasswordRequest $request)
    {
        $user = Sentinel::getUser();
        $password = $request->password;
        if (Sentinel::authenticate([
            'email' => $user->email,
            'password' => $request->old_password
        ])) {
            if ($request->password  == $request->old_password) {
                return response()->json(['error' => 'La nueva contraseña no debe ser igual a la anterior.'],401);
            }
            if (Sentinel::update($user,compact('password'))) {
                return response()->json(['success' => 'Contraseña actualizada correctamente.']);
            } else {
                return response()->json(['error' => 'No se pudo actualizar su contraseña.'],401);
            }
        } else {
            return response()->json(['error' => 'Password actual incorrecta.'],401);
        }
    }
}
