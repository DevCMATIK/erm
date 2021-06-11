<?php

namespace App\App\Jobs\DGA;

use App\Domain\Client\CheckPoint\CheckPoint;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class GetChekpointsToRestore implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $checkpoints =  CheckPoint::with('last_report')
            ->whereNotNull('work_code')
            ->where('dga_report',1)
            ->get();

        foreach ($checkpoints as $checkpoint) {
            RestoreReports::dispatch($checkpoint)->onQueue('long-running-queue-low');
        }


    }
}
