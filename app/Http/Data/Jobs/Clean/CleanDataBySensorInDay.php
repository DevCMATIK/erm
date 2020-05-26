<?php

namespace App\Http\Data\Jobs\Clean;

use App\Domain\Data\Analogous\AnalogousReport;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CleanDataBySensorInDay implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $sensor;
    public $month;
    public $day;


    public function __construct($sensor,$month,$day)
    {
        //
        $this->sensor = $sensor;
        $this->month = $month;
        $this->day = $day;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $month = str_pad($this->month, 2, '0', STR_PAD_LEFT);
        $day = str_pad($this->day, 2, '0', STR_PAD_LEFT);
        for($i=0;$i<24;$i++){
            $hour = str_pad($i, 2, '0', STR_PAD_LEFT);
            $ids = AnalogousReport::select('id')
                    ->where('sensor_id',$this->sensor->id)
                    ->whereRaw("`date` between '2020-{$month}-{$day} {$hour}:01:01' and '2020-{$month}-{$day} {$hour}:29:59'")
                    ->orWhereRaw("`date` between '2020-{$month}-{$day} {$hour}:31:01' and '2020-{$month}-{$day} {$hour}:59:59'")
                    ->get()
                    ->pluck('id')
                    ->toArray();
            if(count($ids) > 0) {
                AnalogousReport::destroy($ids);
            }




        }
    }
}
