<?php

namespace App\Http\Data\Jobs\Restore;

use App\Domain\WaterManagement\Device\Sensor\Electric\ElectricityConsumption;
use App\Domain\WaterManagement\Device\Sensor\Sensor;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class RestoreEnergyConsumption implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $sensor_id;
    public $start_date;
    public $end_date;
    public $current_date;


    public function __construct($sensor_id,$start_date,$end_date,$current_date)
    {
        //
        $this->sensor_id = $sensor_id;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->current_date = $current_date;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $first_date = Carbon::parse($this->current_date)->subDay()->toDateString();
        $sensor =  Sensor::find($this->sensor_id)
            ->whereHas('analogous_reports', $reportsFilter = function($query) use ($first_date){
            return $query->whereRaw("date between '{$first_date} 00:00:00' and '{$this->current_date} 00:01:00'");
        })->with([
            'device.check_point.sub_zones',
            'analogous_reports' => $reportsFilter,
            'consumptions'
        ])->get();

        if(count($sensor->consumptions) > 0) {
            $first_read = $sensor->consumptions->sortByDesc('date')->first()->last_read;
            $last_read = $sensor->analogous_reports->sortByDesc('date')->first()->result;
        } else {
            $first_read = $sensor->analogous_reports->sortBy('date')->first()->result;
            $last_read = $sensor->analogous_reports->sortByDesc('date')->first()->result;
        }
        $consumption_yesterday = $sensor->consumptions->where('date',$first_date)->first();
        if(!$consumption_yesterday) {
            if ($first_read && $last_read) {
                $consumption = $last_read - $first_read;
                ElectricityConsumption::create([
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

        if($this->current_date != $this->end_date) {
            RestoreEnergyConsumption::dispatch($sensor->id,$this->start_date,$this->end_date,Carbon::parse($this->current_date)->addDay()->toDateString())->onQueue('long-running-queue-low');
        }

    }
}
