<?php

namespace App\Mail;

use App\Domain\Data\Export\ExportReminderFile;
use App\Domain\System\File\File;
use App\Domain\WaterManagement\Device\Sensor\Sensor;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class FilesCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user, $reminder;

    public function __construct($user,$reminder)
    {
        $this->user = $user;
        $this->reminder = $reminder;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $files = ExportReminderFile::where('export_reminder_id',$this->reminder->id)->get();
        return $this->from('sys-erm@cmatik.app', 'ERM® CMATIK')
            ->subject('Archivos disponibles para descargar ERM ® '.Carbon::now()->year)
            ->view('emails.files-created')
            ->with([
                    'user' => $this->user,
                    'reminder' => $this->reminder,
                    'files' => $files
            ]);
    }
}
