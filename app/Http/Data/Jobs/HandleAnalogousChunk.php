<?php

namespace App\Http\Data\Jobs;

use App\Domain\Data\Analogous\AnalogousReport;
use App\Domain\WaterManagement\Device\Device;
use App\Domain\WaterManagement\Device\Sensor\Sensor;
use App\Domain\WaterManagement\Historical\HistoricalType;
use App\Http\Data\Jobs\Sensor\ProcessAnalogousDispositionsData;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class HandleAnalogousChunk implements ShouldQueue
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
        if (!$disposition = $this->sensor->selected_disposition->first()) {
           $disposition = $this->sensor->dispositions()->first();
        }

        if ($disposition) {
            foreach ($this->chunk as $row) {
                $value = $row['value'];
                $ingMin = optional($disposition)->sensor_min;
                $ingMax = optional($disposition)->sensor_max;
                $escalaMin = optional($disposition)->scale_min;
                $escalaMax = optional($disposition)->scale_max;
                if($escalaMin == null && $escalaMax == null) {
                    $data = ($ingMin * $value) + $ingMax;
                } else {
                    $f1 = $ingMax - $ingMin;
                    $f2 = $escalaMax - $escalaMin;
                    $f3 = $value - $escalaMin;
                    if($f2 == 0) {
                        $data = ((0)*($f3)) + $ingMin ;
                    } else {
                        $data = (($f1/$f2)*($f3)) + $ingMin ;
                    }
                }
                if($disposition->unit->name == 'mt') {
                    $data = $this->sensor->max_value + $data;
                }
                $ranges = $this->sensor->ranges;
                if (count($ranges) > 0) {
                    foreach($ranges as $range) {
                        if((float)$data >= $range->min && (float)$data <= $range->max) {
                            $color = $range->color;
                        }
                    }
                }
                if(!isset($color) || $color == '') {
                    $color = null;
                }
                array_push($toInsert, [
                    'device_id' => $this->device->id,
                    'register_type' => $this->sensor->address->register_type_id,
                    'address' => $this->sensor->address_number,
                    'sensor_id' => $this->sensor->id,
                    'historical_type_id' => $historical_types->where('internal_id',$row['historical_type'])->first()->id,
                    'scale' => $disposition->name,
                    'scale_min'=> $disposition->scale_min,
                    'scale_max' => $disposition->scale_max,
                    'ing_min' => $disposition->sensor_min,
                    'ing_max' => $disposition->sensor_max,
                    'unit' => $disposition->unit->name,
                    'value' => $value,
                    'result' => $data,
                    'scale_color' => $color,
                    'date' => $row['timestamp'],
                    'pump-location' => $this->sensor->max_value
                ]);


            }
        }
        AnalogousReport::insert($toInsert);
    }
}
