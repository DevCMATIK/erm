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

    public $sensor_type;


    public function __construct($sensor_type)
    {
        $this->sensor_type = $sensor_type;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //->orWhere('slug','ee-e-reactiva')->orWhere('slug','ee-e-aparente')
        $toInsert = array();
        $first_date = Carbon::yesterday()->toDateString();
        $second_date = Carbon::today()->toDateString();
        $sensors =  Sensor::whereHas('type', $typeFilter = function ($q) {
            return $q->where('slug',$this->sensor_type);
        })->whereHas('analogous_reports', $reportsFilter = function($query) use ($first_date,$second_date){
            return $query->whereRaw("date between '{$first_date} 00:00:00' and '{$second_date} 00:01:00'");
        })->with([
            'type' => $typeFilter,
            'device.check_point.sub_zones',
            'analogous_reports' => $reportsFilter,
            'consumptions'
        ])->get();

        foreach($sensors as $sensor) {
            if(count($sensor->consumptions) > 0) {
                $first_read = $sensor->consumptions->sortByDesc('date')->first()->last_read;
                $last_read = $sensor->analogous_reports->sortByDesc('date')->first()->result;
            } else {
                $first_read = $sensor->analogous_reports->sortBy('date')->first()->result;
                $last_read = $sensor->analogous_reports->sortByDesc('date')->first()->result;
            }
            $consumption_yesterday = $sensor->consumptions->where('date',Carbon::yesterday()->toDateString())->first();
            if(!$consumption_yesterday) {
                if($first_read && $last_read) {
                    $consumption = $last_read - $first_read;
                    $first_peak = $sensor->analogous_reports->where('date','>=',$first_date.' 18:00:00')->where('date','<=',$first_date.' 18:30:00')->first();
                    $second_peak = $sensor->analogous_reports->where('date','>=',$first_date.' 23:00:00')->where('date','<=',$first_date.' 23:30:00')->first();
                    if($first_peak && $second_peak) {
                        $peak = $second_peak->result - $first_peak->result;
                    } else {
                        $peak = 0;
                    }
                    array_push($toInsert,[
                        'sensor_id' => $sensor->id,
                        'first_read' => $first_read,
                        'last_read' => $last_read,
                        'consumption' => $consumption,
                        'sensor_type' => $sensor->type->slug,
                        'sub_zone_id' => $sensor->device->check_point->sub_zones->first()->id,
                        'date' => Carbon::yesterday()->toDateString(),
                        'high_consumption' => $peak
                    ]);
                }
            }
        }

        ElectricityConsumption::insert($toInsert);
    }
}
