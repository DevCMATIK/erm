<?php

namespace App\Http\Client\Devices;

use App\Domain\WaterManagement\Device\Log\DeviceOfflineLog;
use App\Http\System\DataTable\DataTableAbstract;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OfflineDevicesLogDatatableController extends DataTableAbstract
{
    public function getRecords()
    {
        return DeviceOfflineLog::where('device_id',$this->filter)->orderBy('id','desc')->take(5)->get();
    }

    public function getRecord($record)
    {
        return [
            $record->start_date,
            $record->end_date ?? 'Vigente',
            ($record->end_date != '')?
                Carbon::parse($record->end_date)->longAbsoluteDiffForHumans(Carbon::parse($record->start_date)) :
                Carbon::now()->longAbsoluteDiffForHumans(Carbon::parse($record->start_date))
        ];
    }
}
