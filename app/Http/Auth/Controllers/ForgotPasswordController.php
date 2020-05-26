<?php

namespace App\Http\Auth\Controllers;

use App\Domain\System\User\User;
use App\Http\Auth\Events\UserFortgotsPassword;
use App\Http\Auth\Requests\PostForgotPasswordRequest;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;

class ForgotPasswordController extends Controller
{
    public function __invoke(PostForgotPasswordRequest $request)
    {
        if ($user = User::where('email',$request->email)->first()) {
            event(new UserFortgotsPassword($user));
        }
        return response()->json(['success' => "Se ha enviado un email de recuperación de contraseña."],200);
    }
}
