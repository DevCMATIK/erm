<?php

namespace App\Http\Auth\Listeners;

use App\Http\Auth\Events\UserRegistered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Reminder;
use Mail;

class SendMailAccountCreated
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

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(UserRegistered $event)
    {
        $reminder = Reminder::exists($event->user) ?:Reminder::create($event->user);
        $this->sendMail($event->user, $reminder->code);
    }

    public function sendMail($user,$code)
    {
        Mail::send('emails.auth.account-created', [
            'user' => $user,
            'code' => $code
        ], function ($message) use ($user){
            $message->from('no-reply@cmatik.cl', 'ERM - Cmatik');
            $message->to($user->email, $user->first_name.' '.$user->last_name);
            $message->bcc('faraya@cmatik.cl','Felipe Araya');
            $message->subject("$user->first_name $user->last_name, Cuenta Creada.");
        });
    }
}
