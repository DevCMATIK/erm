<?php

namespace App\Http\Auth\Controllers;

use App\Http\Auth\Events\UserRegistered;
use App\Http\Auth\Requests\PostRegisterRequest;
use App\App\Controllers\Controller;
use Sentinel;

class RegisterController extends Controller
{
    public function __invoke(PostRegisterRequest $request)
    {
        if ($user = Sentinel::registerAndActivate($request->all())) {
            event(new UserRegistered($user));
            return response()->json(['success' => "Registrado Correctamente."]);
        } else {
            return response()->json(['error' => "No se pudo crear la cuenta."],401);
        }
    }
}
