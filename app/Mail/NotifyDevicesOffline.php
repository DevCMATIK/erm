<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyDevicesOffline extends Mailable
{
    use Queueable, SerializesModels;

    public $logs;

    public function __construct($logs)
    {
        $this->logs = $logs;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('sys-erm@cmatik.app', 'CMATIK - ERM')
            ->subject('Alerta de dispositivos Offline')
            ->view('emails.notify-offline-devices')
            ->with(['logs' => $this->logs]);
    }
}
