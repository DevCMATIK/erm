<?php

namespace App\Http\Data\Jobs\Sensors;

use App\Domain\Data\Analogous\AnalogousDispositionsReport;
use App\Domain\WaterManagement\Device\Sensor\Sensor;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class BackupAnalogousDispositions implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $insertedSensors;

    public function __construct($insertedSensors)
    {
        $this->insertedSensors = $insertedSensors;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $sensors = $this->getInsertedSensors();
        $toInsert = array();
        foreach($sensors as $sensor) {
            $analogous_report = $sensor->analogous_reports->first();
            if(!isset($analogous_report)) {
                continue;
            }
            foreach($sensor->dispositions as $disposition) {
                if($disposition->id == $sensor->default_disposition) {
                    continue;
                } else {
                    if($disposition->name == optional($analogous_report)->scale) {
                        continue;
                    } else {
                        $value = $analogous_report->value;
                        if($sensor->fix_values_out_of_range === 1) {
                            if($value < $disposition->scale_min) {
                                $value = $disposition->scale_min;
                            } else {
                                if($value > $disposition->scale_max) {
                                    $value = $disposition->scale_max;
                                }
                            }
                        }
                        if($disposition->scale_min == null && $disposition->scale_max == null) {
                            $data = ($disposition->sensor_min * $value) + $disposition->sensor_max;
                        } else {
                            $f1 = $disposition->sensor_max - $disposition->sensor_min;
                            $f2 = $disposition->scale_max - $disposition->scale_min;
                            $f3 = $value - $disposition->scale_min;
                            if($f2 == 0) {
                                $data = ((0)*($f3)) + $disposition->sensor_min ;
                            } else {
                                $data = (($f1/$f2)*($f3)) + $disposition->sensor_min ;
                            }
                        }
                        array_push($toInsert, [
                            'analogous_report_id' => $analogous_report->id,
                            'scale' => $disposition->name,
                            'scale_min'=> $disposition->scale_min,
                            'scale_max' => $disposition->scale_max,
                            'ing_min' => $disposition->sensor_min,
                            'ing_max' => $disposition->sensor_max,
                            'unit' => $disposition->unit->name,
                            'value' => $value,
                            'result' => $data
                        ]);
                    }
                }
            }
        }
        AnalogousDispositionsReport::insert($toInsert);
    }

    protected function getInsertedSensors()
    {
        return Sensor::with([
            'device.report',
            'address',
            'dispositions.unit',
            'analogous_reports' => function($q){
                return $q->orderBy('id','desc')->first();
            }
        ])->analogous()
            ->whereIn('id',$this->insertedSensors)
            ->get();
    }
}
