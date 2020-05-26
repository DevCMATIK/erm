<?php

namespace App\Http\Auth\Listeners;

use App\Http\Auth\Events\UserFortgotsPassword;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Reminder;
use Mail;

class SendMailPasswordRecovery
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function handle(UserFortgotsPassword $event)
    {
        $reminder = Reminder::exists($event->user) ?:Reminder::create($event->user);
        $this->sendMail($event->user, $reminder->code);
    }

    public function sendMail($user,$code)
    {
        Mail::send('emails.auth.forgot-password', [
            'user' => $user,
            'code' => $code
        ], function ($message) use ($user){
            $message->from('no-reply@cmatik.cl', 'ERM - Cmatik');
            $message->to($user->email, $user->first_name.' '.$user->last_name);
            $message->subject("Hola $user->first_name $user->last_name, Reestablece tu contraseña.");
        });
    }
}
