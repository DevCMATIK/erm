<?php

namespace App\Http\Data\Jobs\Export;

use App\Domain\System\Mail\MailLog;
use App\Mail\FilesCreatedMail;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class SendMailExportCompleted implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user,$reminder;

    public function __construct($user,$reminder)
    {
        $this->user = $user;
        $this->reminder = $reminder;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->user->email)->send(new FilesCreatedMail($this->user,$this->reminder));

        $log = MailLog::create([
            'mail_id' => null,
            'mail_name' => 'export-reminder',
            'identifier' => 'export-email',
            'date' => Carbon::now()->toDateTimeString(),
        ]);
        $log->users()->create(['user_id' => $this->user->id]);
    }
}
