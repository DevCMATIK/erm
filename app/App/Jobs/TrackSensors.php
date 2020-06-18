<?php

namespace App\App\Jobs;

use App\Domain\WaterManagement\Device\Sensor\Chronometer\ChronometerTracking;
use App\Domain\WaterManagement\Device\Sensor\Chronometer\SensorChronometer;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class TrackSensors implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $chronometers = SensorChronometer::with([
            'sensor.device.report',
            'sensor.dispositions.unit',
            'sensor.address',
            'sensor.selected_disposition.unit',
            'last_tracking'
        ])->where('is_valid',1)->get();

        foreach($chronometers as $chronometer) {
            if(!isset($chronometer->sensor->device->report)) {
                continue;
            }
            $address = $chronometer->sensor->full_address;
            $report_value = optional($chronometer->sensor->device->report)->{$address};

            if (!$disposition = $chronometer->sensor->selected_disposition()->first()) {
                $disposition = $chronometer->sensor->dispositions()->first();
            }
            if($disposition) {
                $result = $this->calculateData($disposition,$report_value,$chronometer->sensor);
            } else {
                $result = $report_value;
            }


            if($result === $chronometer->equals_to) {
                if(!$chronometer->last_tracking) {
                    $chronometer->trackings()->create(['start_date' => Carbon::now()->toDateTimeString(),'value' => $result]);
                } else {
                    if($chronometer->last_tracking && $chronometer->last_tracking->end_date !== null) {
                        $chronometer->trackings()->create(['start_date' => Carbon::now()->toDateTimeString(),'value' => $result]);
                    }
                }

            } else {
                if($chronometer->last_tracking && $chronometer->last_tracking->end_date === null){
                    $last_tracking = $chronometer->last_tracking;
                    $last_tracking->update([
                        'end_date' => Carbon::now()->toDateTimeString(),
                        'diff_in_seconds' => Carbon::now()->toDateTimeString()->diffInSeconds(Carbon::parse($last_tracking->start_date)),
                        'diff_in_minutes' => Carbon::now()->toDateTimeString()->diffInMinutes(Carbon::parse($last_tracking->start_date)),
                        'diff_in_hours' => Carbon::now()->toDateTimeString()->diffInHours(Carbon::parse($last_tracking->start_date)),
                    ]);
                }
            }
        }


    }

    protected function calculateData($disposition,$report_value,$sensor)
    {

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
}
