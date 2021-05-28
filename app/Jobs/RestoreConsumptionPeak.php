<?php

namespace App\Jobs;

use App\Domain\WaterManagement\Device\Sensor\Sensor;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class RestoreConsumptionPeak implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    public $date;
    public $sensor_type = 'ee-e-activa';


    public function __construct($date)
    {
        $this->date = Carbon::parse($date);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $first_date = $this->date->subDay()->toDateString();
        $sensors =  Sensor::whereHas('type', $typeFilter = function ($q) {
            return $q->where('slug',$this->sensor_type);
        })->whereHas('analogous_reports', $reportsFilter = function($query) use ($first_date){
            return $query->whereRaw("date between '{$first_date} 17:50:00' and '{$first_date} 23:55:00'");
        })->with([
            'type' => $typeFilter,
            'analogous_reports' => $reportsFilter,
        ])->get();

        foreach($sensors as $sensor) {
            $consum = $sensor->consumptions->where('date',$this->date->toDateString())->first();
            if($consum) {
                $first_peak = $sensor->analogous_reports->where('date','>=',$first_date.' 18:00:00')->where('date','<=',$first_date.' 18:30:00')->first();
                $second_peak = $sensor->analogous_reports->where('date','>=',$first_date.' 23:00:00')->where('date','<=',$first_date.' 23:30:00')->first();
                if($first_peak && $second_peak) {
                    $peak = $second_peak->result - $first_peak->result;
                } else {
                    $peak = 0;
                }

                $consum->high_consumption = $peak;
                $consum->save();
            }
        }
    }
}
