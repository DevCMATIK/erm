<?php

namespace App\Http\Data\Electric;

use App\Domain\WaterManagement\Device\Sensor\Electric\ElectricityConsumption;
use App\Domain\WaterManagement\Device\Sensor\Sensor;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class BackupSensorEnergy implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $sensor;
    public $date;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($sensor,$date)
    {
        //
        $this->sensor = $sensor;
        $this->date = $date;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $sensor = Sensor::with(['analogous_reports' => function ($q){
            $q->whereRaw("`date` = {$this->date}");
        }])->find($this->sensor->id);
        $first_read = optional($sensor->analogous_reports->first())->result;
        if($first_read && $first_read != '') {
            $last_read = $sensor->analogous_reports->sortByDesc('id')->first()->result;
            $consumption = $last_read - $first_read;
        } else {
            $consumption = 0;
        }
        if(isset($first_read) && $first_read != '' && $consumption > 0){
            ElectricityConsumption::create([
                'sensor_id' => $sensor->id,
                'first_read' => $first_read,
                'last_read' => $last_read,
                'consumption' => $consumption,
                'sensor_type' => $this->sensor->type->slug,
                'sub_zone_id' => $this->sensor->device->check_point->sub_zones->first()->id,
                'date' => Carbon::yesterday()->toDateString()
            ]);
        }
    }
}
