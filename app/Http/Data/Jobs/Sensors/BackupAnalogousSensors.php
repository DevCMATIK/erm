<?php

namespace App\Http\Data\Jobs\Sensors;

use App\App\Traits\ERM\HasAnalogousData;
use App\Domain\Data\Analogous\AnalogousReport;
use App\Domain\WaterManagement\Device\Sensor\Sensor;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;

class   BackupAnalogousSensors implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, HasAnalogousData;


    public $interval;

    public function __construct($interval)
    {
        //
        $this->interval = $interval;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $sensors = $this->getSensors();

        $toInsert = array();

        $insertedSensors = array();

        foreach ($sensors as $sensor) {
            if(!isset($sensor->device->report)) {
                continue;
            }
            $address = $sensor->full_address;
            $report_value = $this->getReportValue($sensor);


            if($sensor->fix_values === 1) {
                if($report_value > $sensor->fix_max_value || $report_value < $sensor->fix_min_value) {
                    $report_value = $sensor->last_value;
                    if($report_value === null) {
                        $report_value = AnalogousReport::where('sensor_id',$sensor->id)->orderBy('date','desc')->take(1)->first()->value ?? null;
                    }

                }
            }
            if($report_value !== null) {
                if (!$disposition = $sensor->selected_disposition()->first()) {
                    $disposition = $sensor->dispositions()->first();
                }
                if($sensor->fix_values === 1) {
                    $sensor->last_value = $report_value;
                    $sensor->save();
                }
                $result = $this->calculateData($disposition,$report_value,$sensor->fix_values_out_of_range,$sensor);
                $range = $this->calculateRange($sensor,$result);
                $interpreters = $sensor->type->interpreters;

                if(count($interpreters) > 0) {
                    if($interpreter = $interpreters->where('value',(int) $result)->first()) {
                        $interpreter = $interpreter->description;
                    } else {
                        $interpreter = null;
                    }
                } else {
                    $interpreter = null;
                }

                if($sensor->type->interval == 77) {
                    if($sensor->last_value != $report_value) {
                        array_push($toInsert, [
                            'device_id' => $sensor->device->id,
                            'register_type' => $sensor->address->register_type_id,
                            'address' => $sensor->address_number,
                            'sensor_id' => $sensor->id,
                            'scale' => $disposition->name,
                            'scale_min'=> $disposition->scale_min,
                            'scale_max' => $disposition->scale_max,
                            'ing_min' => $disposition->sensor_min,
                            'ing_max' => $disposition->sensor_max,
                            'unit' => $disposition->unit->name,
                            'value' => $report_value,
                            'result' => $result,
                            'scale_color' => $range,
                            'interpreter' => $interpreter,
                            'date' => Carbon::now()->toDateTimeString(),
                            'pump_location' => $sensor->max_value
                        ]);
                        $sensor->last_value = $report_value;
                        $sensor->save();
                        array_push($insertedSensors,$sensor->id);
                    }
                } else {
                    array_push($toInsert, [
                        'device_id' => $sensor->device->id,
                        'register_type' => $sensor->address->register_type_id,
                        'address' => $sensor->address_number,
                        'sensor_id' => $sensor->id,
                        'scale' => $disposition->name,
                        'scale_min'=> $disposition->scale_min,
                        'scale_max' => $disposition->scale_max,
                        'ing_min' => $disposition->sensor_min,
                        'ing_max' => $disposition->sensor_max,
                        'unit' => $disposition->unit->name,
                        'value' => $report_value,
                        'result' => $result,
                        'scale_color' => $range,
                        'interpreter' => $interpreter,
                        'date' => Carbon::now()->toDateTimeString(),
                        'pump_location' => $sensor->max_value
                    ]);
                    array_push($insertedSensors,$sensor->id);
                }

            }
        }


        AnalogousReport::insert($toInsert);
        BackupAnalogousDispositions::dispatch($insertedSensors)->onQueue('long-running-queue');
    }

    protected function calculateRange($sensor,$result)
    {
        $ranges = $sensor->ranges;
        if (count($ranges) > 0) {
            foreach($ranges as $range) {
                if((float)$result >= $range->min && (float)$result <= $range->max) {
                    return  $range->color;
                }
            }
        }
        return null;
    }

    protected function calculateData($disposition,$report_value,$fix,$sensor)
    {
        if($fix === 1) {
            if($report_value < $disposition->scale_min) {
                $report_value = $disposition->scale_min;
            } else {
                if($report_value > $disposition->scale_max) {
                    $report_value = $disposition->scale_max;
                }
            }
        }
        if($disposition->scale_min == null && $disposition->scale_max == null) {
            $data = ($disposition->sensor_min * $report_value) + $disposition->sensor_max;
        } else {
            $f1 = $disposition->sensor_max - $disposition->sensor_min;
            $f2 = $disposition->scale_max - $disposition->scale_min;
            $f3 = $report_value - $disposition->scale_min;
            if($f2 == 0) {
                $data = ((0)*($f3)) + $disposition->sensor_min ;
            } else {
                $data = (($f1/$f2)*($f3)) + $disposition->sensor_min ;
            }
        }
        if($disposition->unit->name == 'mt') {
            return $sensor->max_value + $data;
        }
        return $data;
    }

    protected function getSensors()
    {
        return Sensor::with([
            'type.interpreters',
            'device.report',
            'address',
            'dispositions.unit',
            'selected_disposition.unit'
        ])->whereHas('dispositions')
            ->whereHas('type' , function($q){
                return $q->where('interval',$this->interval);
            })
            ->where('sensors.historial', 1)
            ->analogous()
            ->get();
    }
}
