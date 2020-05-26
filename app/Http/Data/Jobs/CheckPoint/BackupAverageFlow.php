<?php

namespace App\Http\Data\Jobs\CheckPoint;

use App\Domain\Client\CheckPoint\Flow\CheckPointFlow;
use App\Domain\WaterManagement\Device\Device;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class BackupAverageFlow implements ShouldQueue
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
        $devices = Device::with([
            'check_point',
            'sensors' => function($q) {
                return $q->sensorType('tx-caudal');
            },
            'sensors.type',
            'sensors.yesterday_analogous_reports'
        ])->whereHas('sensors', function($q){
            return $q->sensorType('tx-caudal');
        })->get();

        $toInsert = array();
        foreach($devices as $device) {
            $avg = '';
            foreach($device->sensors as $sensor) {
                $avg = $sensor->yesterday_analogous_reports->avg('result');
            }
            if(isset($avg) && $avg != ''){
                array_push($toInsert,[
                    'check_point_id' => $device->check_point_id,
                    'average_flow' => $avg,
                    'date' => Carbon::yesterday()->toDateString()
                ]);
            }

        }

        CheckPointFlow::insert($toInsert);
    }
}
