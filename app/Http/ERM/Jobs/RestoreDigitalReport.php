<?php

namespace App\Http\ERM\Jobs;

use App\Domain\Data\Digital\DigitalReport;
use App\Http\ERM\Restores\InsertDigitalReports;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class RestoreDigitalReport implements ShouldQueue
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
        $last_id = DigitalReport::orderBy('date','desc')->first();

        \App\Domain\ERM\DigitalReport::where('id','>',$last_id->id)->chunk(1000, function($reports) {
            InsertDigitalReports::dispatch($reports->toArray());
        });
    }
}
