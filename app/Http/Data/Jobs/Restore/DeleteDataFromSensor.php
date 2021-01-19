<?php

namespace App\Http\Data\Jobs\Restore;

use App\Domain\Data\Analogous\AnalogousReport;
use App\Domain\Data\Digital\DigitalReport;
use App\Domain\WaterManagement\Device\Sensor\Sensor;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class DeleteDataFromSensor implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $sensor_id;
    public $start_date;
    public $end_date;
    public $current_date;


    public function __construct($sensor_id,$start_date,$end_date,$current_date)
    {
        //
        $this->sensor_id = $sensor_id;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->current_date = $current_date;
    }


    public function handle()
    {
        $sensor = Sensor::with(['device','address','type'])->find($this->sensor_id);


        if($sensor->address->configuration_type == 'scale') {
            AnalogousReport::where('sensor_id',$this->sensor_id)
                ->whereRaw("date between '{$this->current_date} 00:00:00' and '{$this->current_date} 23:59:59'")
                ->delete();
        } else {
            DigitalReport::where('sensor_id',$this->sensor_id)
                ->whereRaw("date between '{$this->current_date} 00:00:00' and '{$this->current_date} 23:59:59'")
                ->delete();
        }

        if($this->current_date != $this->end_date) {
            DeleteDataFromSensor::dispatch($this->sensor_id,$this->start_date,$this->end_date,Carbon::parse($this->current_date)->addDay()->toDateString())->onQueue('long-running-queue-low');
        }
    }
}
