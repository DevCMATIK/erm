<?php

namespace App\Mail;

use App\Domain\System\Mail\MailAttachable;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SystemMail extends Mailable
{
    use  Queueable,SerializesModels;

    public $mail,$date,$receptor,$sensor,$check_point,$device,$zone,$sub_zone,$alarm_type,$value,$alarm_date,$sensor_list,$datetime,$current_time,$alarm_time;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(
        $mail,
        $date = false,
        $receptor = false,
        $sensor = false,
        $check_point = false,
        $device = false,
        $zone = false,
        $sub_zone = false,
        $alarm_type = false,
        $value = false,
        $alarm_date = false,
        $sensor_list = false,
        $datetime = false,
        $current_time = false,
        $alarm_time = false
    ){
        $this->mail = $mail;
        $this->receptor = $receptor;
        $this->sensor = $sensor;
        $this->check_point = $check_point;
        $this->device = $device;
        $this->date = $date;
        $this->zone = $zone;
        $this->sub_zone = $sub_zone;
        $this->alarm_type = $alarm_type;
        $this->value = $value;
        $this->alarm_date = $alarm_date;
        $this->sensor_list = $sensor_list;
        $this->datetime = $datetime;
        $this->current_time = $current_time;
        $this->alarm_time = $alarm_time;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('no-reply@cmatik.cl', 'CMATIK - ERM')
                    ->subject($this->replaceSubjectAttachables($this->mail->subject))
                    ->view('emails.dynamic')
                    ->with(['body' => $this->replaceAttachables(),
                            'header' => $this->replaceHeaderAttachables()]);
    }

    protected function replaceHeaderAttachables()
    {
        $attachables = MailAttachable::get();
        $header = $this->mail->header;
        foreach ($attachables as $attachable) {
            $var = str_replace('@','',$attachable->code);
            $header = str_replace($attachable->code,($this->{$var} ?? 'undefined'),$header);

        }

        return $header;
    }

    protected function replaceAttachables()
    {
        $attachables = MailAttachable::get();
        $body = $this->mail->body;
        foreach ($attachables as $attachable) {
            $var = str_replace('@','',$attachable->code);
            $body = str_replace($attachable->code,($this->{$var} ?? 'undefined'),$body);

        }

        return $body;
    }

    protected function replaceSubjectAttachables($subject)
    {
        $attachables = MailAttachable::get();
        $body = $subject;
        foreach ($attachables as $attachable) {
            $var = str_replace('@','',$attachable->code);
            $body = str_replace($attachable->code,($this->{$var} ?? 'undefined'),$body);

        }

        return $body;
    }
}
