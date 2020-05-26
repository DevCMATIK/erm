<?php

namespace App\Http\Data\Jobs\Clean;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CleanDataBySensor implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $sensor;

    public function __construct($sensor)
    {
        //
        $this->sensor = $sensor;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //meses
        for($i=1;$i<5;$i++){
            CleanDataBySensorInMonth::dispatch($this->sensor,$i)->onQueue('long-running-backup');
        }
    }
}
