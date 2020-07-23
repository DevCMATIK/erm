<?php

namespace App\Http\System\User\Listeners;

use App\Http\System\User\Events\AdminRegistersUser;
use Reminder;
use Mail;

class SendEmailAccountCreated
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

    public function handle(AdminRegistersUser $event)
    {
        $reminder = Reminder::exists($event->user) ?: Reminder::create($event->user);
        $this->sendEmail($event->user,$reminder->code);
    }

    public function sendEmail($user,$code)
    {
        Mail::send('emails.users.account-created', [
            'user' => $user,
            'code' => $code
        ], function ($message) use ($user){
            $message->from('sys-erm@cmatik.app', 'ERM® CMATIK');
            $message->to($user->email, $user->first_name.' '.$user->last_name);
            $message->subject("Acceso a nuestro sistema.");
        });
    }
}
