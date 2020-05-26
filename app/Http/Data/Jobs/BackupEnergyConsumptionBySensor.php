<?php

namespace App\Http\Data\Jobs;

use App\Domain\Data\Analogous\AnalogousReport;
use App\Domain\WaterManagement\Device\Sensor\Electric\ElectricityConsumption;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class BackupEnergyConsumptionBySensor implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $sensor;

    public function __construct($sensor)
    {
        $this->sensor = $sensor;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $days = AnalogousReport::where('sensor_id',$this->sensor->id)->orderBy('date')->get()->groupBy(function($date) {
            return Carbon::parse($date->date)->format('m-d');
        });

        $toInsert = array();

        foreach($days as $key => $day) {
            $first_read = $day->first()->result;
            $last_read = $day->sortByDesc('id')->first()->result;
            $consumption = $last_read - $first_read;
            if($consumption > 0){
                array_push($toInsert,[
                    'sensor_id' => $this->sensor->id,
                    'first_read' => $first_read,
                    'last_read' => $last_read,
                    'consumption' => $consumption,
                    'sensor_type' => $this->sensor->type->slug,
                    'sub_zone_id' => $this->sensor->device->check_point->sub_zones()->first()->id,
                    'date' => Carbon::parse($day->first()->date)->toDateString()
                ]);
            }
        }

        ElectricityConsumption::insert($toInsert);
    }
}
