<?php

namespace App\Http\ERM\Jobs;

use App\Domain\Data\Analogous\AnalogousReport;
use App\Http\ERM\Restores\InsertAnalogousReports;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class RestoreAnalogousReport implements ShouldQueue
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
        $last_id = AnalogousReport::orderBy('date','desc')->first();

        \App\Domain\ERM\AnalogousReport::where('id','>',$last_id->id)->chunk(1000, function($reports) {
            InsertAnalogousReports::dispatch($reports->toArray());
        });
    }
}
