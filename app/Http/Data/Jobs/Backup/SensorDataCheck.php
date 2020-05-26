<?php

namespace App\Http\Data\Jobs\Backup;

use App\Domain\Backup\SensorBackupCheck;
use App\Domain\WaterManagement\Main\Historical;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SensorDataCheck implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $sensor;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($sensor)
    {
        //
        $this->sensor = $sensor;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $rows = Historical::where('grd_id', $this->sensor->device->internal_id)
            ->where('register_type',$this->sensor->address->register_type_id)
            ->where('address',$this->sensor->address_number)
            ->whereRaw("timestamp between '2020-02-23' and '2020-04-27'")
            ->get();
        $entries = count($rows);
        if($entries > 0) {
            $start = $rows->first()->timestamp;
            $end = $rows->sortByDesc('timestamp')->first()->timestamp;
        } else {
            $start = null;
            $end = null;
            $entries = null;
        }
        SensorBackupCheck::create([
            'device_id' => $this->sensor->device_id,
            'sensor_id' => $this->sensor->id,
            'start' => $start,
            'end' => $end,
            'entries' => $entries
        ]);
    }
}
