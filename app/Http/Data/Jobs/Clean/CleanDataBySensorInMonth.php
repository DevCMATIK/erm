<?php

namespace App\Http\Data\Jobs\Clean;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CleanDataBySensorInMonth implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $sensor;
    public $month;


    public function __construct($sensor,$month)
    {
        //
        $this->sensor = $sensor;
        $this->month = $month;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        for($i=1;$i<32;$i++){
            if($this->month != 4 || $i < 25 ) {
                CleanDataBySensorInDay::dispatch($this->sensor,$this->month,$i)->onQueue('long-running-backup');
            }
        }
    }
}
