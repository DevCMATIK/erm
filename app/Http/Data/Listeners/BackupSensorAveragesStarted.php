<?php

namespace App\Http\Data\Listeners;

use App\Http\Data\Events\BackupedAverages;
use App\Http\Data\Events\BackupSensorAverages;
use App\Http\Data\Jobs\HandleSensorAverages;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class BackupSensorAveragesStarted
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(BackupSensorAverages $event)
    {
        $records = $event->sensor->analogous_reports()->orderBy('date')->chunk(1000,function($chunk) {
            HandleSensorAverages::dispatch($chunk);
        });


    }
}
