<?php

namespace App\Http\Data\Jobs\CheckPOint;

use App\Domain\Client\Zone\Sub\SubZone;
use App\Domain\WaterManagement\Device\Consumption\DeviceConsumption;
use App\Domain\WaterManagement\Device\Sensor\Sensor;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CalculateConsumptions implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $toInsert = array();
        $check_points = $this->getSensors();
        foreach($check_points as $check => $type) {
            foreach($type as $tpe => $sensor){
                $s = $sensor->first();
                $cost = $s->device->check_point->sub_zones->first()->energy_cost->hour_cost;
                $first = optional($s->last_hour_analogous_report)->sortBy('date')->first()->result;
                $last = optional($s->last_hour_analogous_report)->sortByDesc('date')->first()->result;
                if(isset($last) && isset($first)) {
                    if($tpe == 'ee-e-activa') {
                        $energy = $last - $first;
                    } else {
                        $input = $last - $first;
                    }
                }
            }
            if((int)$input === 0 || (int)$energy === 0 || (int)$cost === 0){
                $hour_consumption = 0;
            } else {
                    $hour_consumption = (($energy*$cost)/$input);

            }


            if(isset($energy) && isset($input)) {
                array_push($toInsert,[
                    'check_point_id' => $check,
                    'active_energy' => $energy,
                    'water_input' => $input,
                    'hour_value' => $cost,
                    'hour_consumption' => $hour_consumption,
                    'date' => Carbon::now()->toDateTimeString()
                ]);
            }
        }

        DeviceConsumption::insert($toInsert);
    }

    protected function getSensors()
    {
        $sub_zones = SubZone::with('check_points.devices.sensors.type')->whereHas('energy_cost')->get();
        $sensors = array();
        foreach($sub_zones as $sub_zone) {
            foreach($sub_zone->check_points as $check_point){
                foreach($check_point->devices as $device){
                    foreach($device->sensors as $sensor) {
                        if($sensor->type->slug == 'ee-e-activa' || $sensor->type->slug == 'totalizador') {
                            array_push($sensors,$sensor->id);
                        }
                    }
                }
            }
        }

        $sensors_id = collect($sensors)->unique()->toArray();
        return Sensor::with([
            'type' => function ($q) {
                return $q->where('slug','ee-e-activa')->orWhere('slug','totalizador');
            },
            'device.check_point.sub_zones.energy_cost',
            'last_hour_analogous_report'
        ])->whereHas('type', function ($q) {
            return $q->where('slug','ee-e-activa')->orWhere('slug','totalizador');
        })->whereHas('last_hour_analogous_report')->whereIn('id',$sensors_id)->get()->groupBy('device.check_point_id')->map(function($item){
            return $item->groupBy('type.slug');
        })->filter(function($item){
            return $item->count()  == 2;
        });


    }
}
