<?php

namespace App\Http\Data\Jobs;

use App\Domain\Data\Digital\DigitalReport;
use App\Domain\WaterManagement\Device\Device;
use App\Domain\WaterManagement\Device\Sensor\Sensor;
use App\Domain\WaterManagement\Historical\HistoricalType;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class HandleDigitalChunk implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $device;

    public $sensor;

    public $month;

    public $chunk;


    public function __construct(Device $device, Sensor $sensor,$month,$chunk)
    {
        $this->device = $device;
        $this->sensor = $sensor;
        $this->month = $month;
        $this->chunk = $chunk;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $historical_types = HistoricalType::get();
        $toInsert = array();
        $label = $this->sensor->label;
        if ($label) {
            foreach ($this->chunk as $row) {
                array_push($toInsert, [
                    'device_id' => $this->device->id,
                    'register_type' => $this->sensor->address->register_type_id,
                    'address' => $this->sensor->address_number,
                    'sensor_id' => $this->sensor->id,
                    'historical_type_id' => (isset($row['historical_type']) && $row['historical_type'] != null)?$historical_types->where('internal_id',$row['historical_type'])->first()->id:null,
                    'name' => $this->sensor->name,
                    'on_label' => $label->on_label,
                    'off_label' => $label->off_label,
                    'value' => $row['value'],
                    'label' => ($row['value'] == 1)? $label->on_label : $label->off_label,
                    'date' => $row['timestamp']
                ]);
            }
        }

        DigitalReport::insert($toInsert);

    }
}
