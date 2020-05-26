<?php

namespace App\Http\Data\Jobs\Clean;

use App\Domain\Data\Analogous\AnalogousReport;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ChangeWaterTableOnAnalogousReports implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $sensor;
    public $date;


    public function __construct($sensor,$date)
    {
        //
        $this->sensor = $sensor;
        $this->$date = $date;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $max_value = $this->sensor->max_value;
        AnalogousReport::select('id')->where('sensor_id',$this->sensor->id)->between('date',$this->date.'-01',$this->date.'-31')->chunk(500, function($reports) use($max_value) {
            ChangeWaterTableOnAnalogousReportsChunk::dispatch($reports,$max_value)->onQueue('long-running-backup');
        });

    }
}
