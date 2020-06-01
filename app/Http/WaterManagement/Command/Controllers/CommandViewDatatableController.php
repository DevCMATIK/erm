<?php

namespace App\Http\WaterManagement\Command\Controllers;

use App\Domain\WaterManagement\Log\CommandLog;
use App\Http\System\DataTable\DataTableAbstract;


class CommandViewDatatableController extends DataTableAbstract
{
    public function getRecords()
    {
        return CommandLog::with([
            'user',
            'device.check_point.sub_zones',
            'sensor.address',
            'sensor.label'
        ])->orderBy('execution_date','desc')->get();
    }

    public function getRecord($record)
    {
        return [
            optional($record->user)->full_name,
            optional($record->user)->email,
            optional($record->device)->name,
            optional($record->device)->check_point->sub_zones->first()->name,
            optional($record->sensor)->name,
            optional($record->sensor)->full_address,
            $record->grd_id,
            ($record->order_executed === 1)?optional(optional($record->sensor)->label)->on_label:optional(optional($record->sensor)->label)->off_label ,
            $record->execution_date,
            $record->ip_address
        ];
    }
}
