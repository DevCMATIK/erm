<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use NotificationChannels\ChatAPI\ChatAPIChannel;
use NotificationChannels\ChatAPI\ChatAPIMessage;

class WhatsappMessage extends Notification
{


    public function via($notifiable)
    {
        return [ChatAPIChannel::class];
    }

    public function toChatAPI($notifiable)
    {
        return ChatAPIMessage::create()
            ->to($notifiable->phone) // your user phone
        ->content('test from ERM');
    }
}
