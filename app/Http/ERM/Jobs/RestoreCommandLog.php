<?php

namespace App\Http\ERM\Jobs;

use App\Domain\WaterManagement\Log\CommandLog;
use App\Http\ERM\Restores\InsertCommandLogs;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class RestoreCommandLog implements ShouldQueue
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
        $last_id = CommandLog::orderBy('id','desc')->first();

        \App\Domain\ERM\CommandLog::where('id','>',$last_id->id)->chunk(1000, function($reports) {
            InsertCommandLogs::dispatch($reports->toArray());
        });
    }
}
