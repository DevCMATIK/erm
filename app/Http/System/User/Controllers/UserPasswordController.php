<?php

namespace App\Http\System\User\Controllers;

use App\Domain\System\User\User;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;
use Sentinel;

class UserPasswordController extends Controller
{
    public function index($id)
    {
        $user = User::find($id);
        return view('system.user.password.index',compact('user'));
    }

    public function changePassword(Request $request)
    {
        if ($user = User::where('email',$request->email)->first()) {
            $password = explode('@',$user->email)[0].rand(1,1500);
            if (Sentinel::update($user,compact('password'))) {
                return response()->json(['success' => "Se ha cambiado la contraseña a: <b>$password</b>; cópiela."]);
            } else {
                return response()->json(['error' => "No se pudo cambiar la contraseña."],401    );
            }
        } else {
            return response()->json(['error' => 'El email no existe'],401);
        }
    }
}
