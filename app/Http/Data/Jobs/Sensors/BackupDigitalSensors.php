<?php

namespace App\Http\Data\Jobs\Sensors;

use App\App\Traits\ERM\HasAnalogousData;
use App\Domain\Data\Digital\DigitalReport;
use App\Domain\WaterManagement\Device\Sensor\Sensor;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class BackupDigitalSensors implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels,HasAnalogousData;

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
        $sensors = $this->getSensors();

        $toInsert = array();

        foreach($sensors as $sensor) {
            if(!isset($sensor->device->report)) {
                continue;
            }
            $address = $sensor->full_address;
            $report_value = $this->getReportValue($sensor);

            if(!isset($sensor->address_number)) {
                continue;
            }

            array_push($toInsert, [
                'device_id' => $sensor->device->id,
                'register_type' => $sensor->address->register_type_id,
                'address' => $sensor->address_number,
                'sensor_id' => $sensor->id,
                'name' => $sensor->name,
                'on_label' => $sensor->label->on_label,
                'off_label' => $sensor->label->off_label,
                'value' => $report_value,
                'label' => ($report_value === 1)? $sensor->label->on_label : $sensor->label->off_label,
                'date' => Carbon::now()->toDateTimeString()
            ]);
        }

        DigitalReport::insert($toInsert);
    }

    protected function getSensors()
    {
        return Sensor::with([
            'device.report',
            'address',
            'label'
        ])
            ->where('sensors.historial',1)
            ->whereHas('label')
            ->digital()
            ->get();
    }
}
