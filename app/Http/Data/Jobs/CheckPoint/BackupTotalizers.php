<?php

namespace App\Http\Data\Jobs\CheckPoint;

use App\Domain\Client\CheckPoint\Flow\CheckPointFlow;
use App\Domain\Client\CheckPoint\Totalizer\CheckPointTotalizer;
use App\Domain\WaterManagement\Device\Device;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class BackupTotalizers implements ShouldQueue
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
            'check_point.totalizers',
            'sensors' => function ($q) {
                return $q->sensorType('totalizador');
            },
            'sensors.type',
            'sensors.yesterday_analogous_reports'
        ])->whereHas('sensors', function ($q) {
            return $q->sensorType('totalizador');
        })->get();

        $toInsert = array();
        foreach ($devices as $device) {
            if (!$lastRead = optional($device->check_point->totalizers()->orderBy('id', 'desc')->first())->last_read) {
                $lastRead = optional($device->sensors->first()->yesterday_analogous_reports->first())->result;
            }
            if ($lastRead) {

                foreach($device->sensors as $sensor) {
                    $first_read = optional($sensor->yesterday_analogous_reports->first())->result;
                    if($first_read && $first_read != '') {
                        $last_read = $sensor->yesterday_analogous_reports->sortByDesc('id')->first()->result;
                        if($first_read < $lastRead) {
                            $first_read = $lastRead;
                            $totalizer_fix = $lastRead;
                        }
                        $input = $last_read - $first_read;
                    }
                    break;
                }
                if(isset($first_read) && $first_read != '' && $input > 0){
                    array_push($toInsert,[
                        'check_point_id' => $device->check_point_id,
                        'first_read' => $first_read,
                        'last_read' => $last_read,
                        'input' => $input,
                        'totalizer_fix' => $totalizer_fix ?? null,
                        'date' => Carbon::yesterday()->toDateString()
                    ]);
                }
            }
        }

        CheckPointTotalizer::insert($toInsert);
    }
}
