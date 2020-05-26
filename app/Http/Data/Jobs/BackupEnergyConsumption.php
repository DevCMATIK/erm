<?php

namespace App\Http\Data\Jobs;

use App\Domain\WaterManagement\Device\Sensor\Sensor;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class BackupEnergyConsumption implements ShouldQueue
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
        ])->whereHas('type', function ($q) {
            return $q->where('slug','ee-e-activa')->orWhere('slug','ee-e-reactiva')->orWhere('slug','ee-e-aparente');
        })->get();

        foreach($sensors as $sensor)
        {
            BackupEnergyConsumptionBySensor::dispatch($sensor)->onQueue('long-running-backup');
        }
    }
}
