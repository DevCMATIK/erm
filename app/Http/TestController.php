<?php

namespace App\Http;

use App\App\Controllers\Soap\SoapController;
use App\Domain\WaterManagement\Device\Sensor\Sensor;
use App\Domain\WaterManagement\Main\Historical;
use App\Http\Data\Jobs\Restore\RestoreEnergyConsumption;
use Carbon\Carbon;
use Sentinel;


class TestController extends SoapController
{

    public $current_date = '2020-12-01';

    public function __invoke()
    {
        $sensor = Sensor::with(['device','address','type','dispositions','selected_disposition','ranges'])->find(1632);

        $rows = Historical::where('grd_id', $sensor->device->internal_id)
            ->where('register_type',$sensor->address->register_type_id)
            ->where('address',$sensor->address_number)
            ->whereRaw("timestamp between '{$this->current_date} 00:00:00' and '{$this->current_date} 23:59:59'")
            ->get();
        $current_date = $this->current_date;
        $newRows = array();
        for($i= 0;$i<24;$i++) {
            $hour = str_pad($i, 2, '0', STR_PAD_LEFT);
            $row = $rows->filter(function($item) use ($hour,$current_date){
                return (
                    strtotime($item->timestamp) > strtotime("{$current_date} {$hour}:00:00")
                    && strtotime($item->timestamp) < strtotime("{$current_date} {$hour}:29:59")
                );
            })->first();
            dd($row);
            if($row) {
                array_push($newRows,$row->toArray());
            }
            $row = $rows->filter(function($item) use ($hour,$current_date){
                return (
                    strtotime($item->timestamp) > strtotime("{$current_date} {$hour}:30:00")
                    && strtotime($item->timestamp) < strtotime("{$current_date} {$hour}:59:59")
                );
            })->first();
            if($row) {
                array_push($newRows,$row->toArray());
            }
        }
        dd($newRows,$rows);
    }
}
