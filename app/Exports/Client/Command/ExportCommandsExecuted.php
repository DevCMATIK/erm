<?php

namespace App\Exports\Client\Command;

use App\Domain\WaterManagement\Group\Group;
use App\Domain\WaterManagement\Log\CommandLog;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Sentinel;

class ExportCommandsExecuted implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;


    public function map($rows): array
    {
        return [
            optional($rows->device->check_point->sub_zones()->first())->zone->name,
            optional($rows->device->check_point->sub_zones()->first())->name,
            optional($rows->device->check_point)->name,
            optional($rows->sensor)->name,
            ($rows->order_executed === 1)?optional(optional($rows->sensor)->label)->on_label:optional(optional($rows->sensor)->label)->off_label ,
            optional($rows->user)->full_name,
            $rows->execution_date
        ];
    }

    public function query()
    {
        return CommandLog::with([
            'user.groups',
            'device.check_point.sub_zones.zone',
            'sensor.address',
            'sensor.label'
        ])->whereDoesntHave('user', function($q){
            $group = Group::with('users')->whereSlug('cmatik')->first();
            return $q->whereIn('id',$group->users()->get()->pluck('id')->toArray());
        })->whereHas('device',function($q){
            return $q->whereHas('check_point',function($q){
                return $q->whereHas('sub_zones',function($q){
                    $userSubzones = Sentinel::getUser()->sub_zones->pluck('id');
                    return $q->whereIn('id',$userSubzones);
                });
            });
        })->orderBy('execution_date','desc');
    }

    public function headings(): array
    {
        return [
            'Zona',
            'Sub zona',
            'Punto de Control',
            'Variable',
            'Orden Ejecutada',
            'Usuario',
            'Fecha'
        ];
    }


}
