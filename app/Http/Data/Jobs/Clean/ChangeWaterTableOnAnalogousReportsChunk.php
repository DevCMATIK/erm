<?php

namespace App\Http\Data\Jobs\Clean;

use App\Domain\Data\Analogous\AnalogousReport;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;

class ChangeWaterTableOnAnalogousReportsChunk implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $reports;
    public $max_value;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($reports, $max_value)
    {
        //
        $this->reports = $reports;
        $this->max_value = $max_value;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $ids = $this->reports->pluck('id')->toArray();
        AnalogousReport::whereIn('id',$ids)->update(['result' => DB::raw($this->max_value .' + result')]);
            $result = (float)number_format(($this->max_value + (float)$report->result),2,'.','');

    }
}
