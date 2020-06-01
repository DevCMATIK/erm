<?php

namespace App\Http\WaterManagement\Device\Sensor\Alarm\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendMailAlarms implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $alarm;
    public $value;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($alarm,$value)
    {
        //
        $this->alarm = $alarm;
        $this->value = $value;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
    }
}
