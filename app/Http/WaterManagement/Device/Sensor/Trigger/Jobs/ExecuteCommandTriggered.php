<?php

namespace App\Http\WaterManagement\Device\Sensor\Trigger\Jobs;

use App\Domain\WaterManagement\Device\Sensor\Trigger\SensorTrigger;
use App\Http\WaterManagement\Device\Sensor\Trigger\Traits\TriggersCommandTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ExecuteCommandTriggered implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, TriggersCommandTrait;

    public $minutes;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($minutes)
    {
        $this->minutes = $minutes;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $triggers = SensorTrigger::with(['sensor.device','sensor.address','receptor.device','receptor.address','sensor.dispositions'])->where('minutes',$this->minutes)->get();
        $this->handleTriggers($triggers);
    }
}
