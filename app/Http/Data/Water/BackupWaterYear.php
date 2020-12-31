<?php

namespace App\Http\Data\Water;

use App\Domain\WaterManagement\Device\Sensor\Sensor;
use App\Domain\WaterManagement\Sensor\Consumption\WaterConsumption;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class BackupWaterYear implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $day;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($day)
    {

        $this->day = $day;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $toInsert = array();
        $date = Carbon::parse($this->day);
        if($date->toDateString() != now()->toDateString()) {
            $first_date = $date->toDateString();
            $second_date = $date->addDay()->toDateString();
            $sensors =  Sensor::whereHas('type', $typeFilter = function ($q) {
                return $q->where('sensor_type','tote');
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
                $consumption_yesterday = $sensor->consumptions->where('date',$first_date)->first();
                if(!$consumption_yesterday) {
                    if($first_read && $last_read) {
                        $consumption = $last_read - $first_read;

                        array_push($toInsert,[
                            'sensor_id' => $sensor->id,
                            'first_read' => $first_read,
                            'last_read' => $last_read,
                            'consumption' => $consumption,
                            'sensor_type' => $sensor->type->slug,
                            'sub_zone_id' => $sensor->device->check_point->sub_zones->first()->id,
                            'date' => $first_date
                        ]);
                    }
                }
            }

            WaterConsumption::insert($toInsert);
            BackupWaterYear::dispatch($date->addDay()->toDateString())->onQueue('long-running-backup');
        }
    }
}
