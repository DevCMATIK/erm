<?php

namespace App\Http\Data\Electric;

use App\Domain\WaterManagement\Device\Device;
use App\Domain\WaterManagement\Device\Sensor\Electric\ElectricityConsumption;
use App\Domain\WaterManagement\Device\Sensor\Sensor;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class BackupEnergy implements ShouldQueue
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
        $sensors = Sensor::with([
            'type' => function ($q) {
                return $q->where('slug','ee-e-activa')->orWhere('slug','ee-e-reactiva')->orWhere('slug','ee-e-aparente');
            },
            'device.check_point.sub_zones',
            'yesterday_analogous_reports'
        ])->whereHas('type', function ($q) {
            return $q->where('slug','ee-e-activa')->orWhere('slug','ee-e-reactiva')->orWhere('slug','ee-e-aparente');
        })->get();

        $toInsert = array();
        foreach($sensors as $sensor) {
            $first_read = optional($sensor->yesterday_analogous_reports->first())->result;
            if($first_read && $first_read != '') {
                $last_read = $sensor->yesterday_analogous_reports->sortByDesc('id')->first()->result;
                $consumption = $last_read - $first_read;
            } else {
                $consumption = 0;
            }
            if(isset($first_read) && $first_read != '' && $consumption > 0){
                array_push($toInsert,[
                    'sensor_id' => $sensor->id,
                    'first_read' => $first_read,
                    'last_read' => $last_read,
                    'consumption' => $consumption,
                    'sensor_type' => $sensor->type->slug,
                    'sub_zone_id' => $sensor->device->check_point->sub_zones->first()->id,
                    'date' => Carbon::yesterday()->toDateString()
                ]);
            }
        }



        ElectricityConsumption::insert($toInsert);

    }
}
