<?php

namespace App\Domain\Production;

use App\Domain\Production\AnalogousReport\AnalogousReport;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class InsertDataFromProduction implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $chunk;

    public function __construct($chunk)
    {
        //
        $this->chunk = $chunk;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        AnalogousReport::insert($this->chunk->toArray());
    }
}
