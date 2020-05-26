<?php

namespace App\Domain\Production;

use App\Domain\Production\AnalogousReport\AnalogousReportBackup;
use App\Domain\WaterManagement\Device\Sensor\Sensor;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class GetReportsFromBackup implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $hour;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($hour)
    {
        //
        $this->hour = $hour;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $sensors_ids = Sensor::with('address')->whereHas('type',function($query){
            return $query->where('interval',5);
        })->get()->pluck('id')->toArray();

        AnalogousReportBackup::select([
            'device_id',
            'register_type',
            'address',
            'sensor_id',
            'historical_type_id',
            'scale',
            'scale_min',
            'scale_max',
            'ing_min',
            'ing_max',
            'unit',
            'value',
            'result',
            'date',
            'scale_color',
            'interpreter'
        ])->whereIn('sensor_id',$sensors_ids)->whereRaw("`date` between '2020-01-01' and '2020-04-28' and time(`date`) between '{$this->hour}:34:59' and '{$this->hour}:55:30'")->chunk(100, function($reports){
            InsertDataFromProduction::dispatch($reports)->onQueue('long-running-queue-low');
        });
    }
}
