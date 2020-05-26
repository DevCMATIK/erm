<?php

namespace App\Http\Auth\Controllers;

use App\Http\Auth\Requests\PostLoginRequest;
use App\App\Controllers\Controller;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;
use Sentinel;

class LoginController extends Controller
{
    public function postLogin(PostLoginRequest $request)
    {
        try {
            $remember_me = false;

            if (isset($request->rememberMe)) {
                $remember_me = true;
            }

            if(Sentinel::authenticate($request->all(),$remember_me)) {
                return response()->json(['success' => 'Login Correcto, Bienvenido/a.']);
            } else {
                return response()->json(['error' => 'Email y/o Password incorrectos.'],401);
            }

        } catch(ThrottlingException $e) {
            $delay = $e->getDelay();
            return response()->json([
                'error' => "Demasiados intenos erróneos, Login bloqueado por $delay segundos"
            ], 401);
        }
    }

    public function logout()
    {
        Sentinel::logout();
        return redirect('/login');
    }
}
