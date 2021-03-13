<?php

namespace App\Http\WaterManagement\Report\Jobs;

use App\Domain\WaterManagement\Report\MailReport;
use App\Http\WaterManagement\Report\Traits\SendMailReportTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendReportMail
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, SendMailReportTrait;

    public $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $reportMail = MailReport::with([
            'sensors.device.report',
            'sensors.device.check_point.type',
            'sensors.device.check_point.sub_zones.zone',
            'sensors.dispositions.unit',
            'sensors.address',
            'groups.users',
            'mail'
        ])->find($this->id);

        //$this->handleReportEmail($reportMail);
    }
}
