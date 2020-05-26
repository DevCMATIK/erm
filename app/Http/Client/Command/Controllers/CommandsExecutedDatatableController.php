<?php

namespace App\Http\Client\Command\Controllers;

use App\Domain\WaterManagement\Group\Group;
use App\Domain\WaterManagement\Log\CommandLog;
use App\Http\System\DataTable\DataTableAbstract;
use Sentinel;

class CommandsExecutedDatatableController extends DataTableAbstract
{
    public $entity = 'commands-executed';

    public function getRecords()
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
        })->orderBy('execution_date','desc')->get();
    }

    public function getRecord($record)
    {
        return [
            optional($record->device->check_point->sub_zones()->first())->zone->name,
            optional($record->device->check_point->sub_zones()->first())->name,
            optional($record->device->check_point)->name,
            optional($record->sensor)->name,
            ($record->order_executed === 1)?optional(optional($record->sensor)->label)->on_label:optional(optional($record->sensor)->label)->off_label ,
            optional($record->user)->full_name,
            $record->execution_date
        ];
    }
}
