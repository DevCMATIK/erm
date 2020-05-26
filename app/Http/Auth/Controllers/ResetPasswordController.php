<?php

namespace App\Http\Auth\Controllers;

use App\Domain\System\User\User;
use App\Http\Auth\Requests\PostResetPasswordRequest;
use App\App\Controllers\Controller;
use Reminder;

class ResetPasswordController extends Controller
{
    public function index($email,$code)
    {
        if ($user = User::where('email',$email)->first()) {
            if($reminder = Reminder::exists($user)) {
                if( $code == $reminder->code) {
                    return view('auth.pages.reset-password', compact(['user','code']));
                } else {
                    return redirect('/');
                }
            } else {
                return redirect('/');
            }
        } else  {
            abort(404);
        }
    }

    public function postResetPassword (PostResetPasswordRequest $request,$email,$code)
    {
        if ($user = User::where('email',$email)->first()) {
            if ($reminder = Reminder::exists($user)) {
                if ($code && $reminder->code) {
                    Reminder::complete($user, $code, $request->password);
                    return response()->json(['success' => 'Se ha cambiado la contraseña'], 200);
                } else {
                    return redirect('/');
                }
            } else {
                return redirect('/');
            }
        } else {
            abort(404);
        }
    }
}
