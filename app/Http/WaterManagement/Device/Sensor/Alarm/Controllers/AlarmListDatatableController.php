<?php

namespace App\Http\WaterManagement\Device\Sensor\Alarm\Controllers;

use App\Domain\WaterManagement\Device\Sensor\Alarm\SensorAlarm;
use App\Http\System\DataTable\DataTableAbstract;
use Sentinel;

class AlarmListDatatableController extends DataTableAbstract
{
    public $entity = 'alarms-list';

    public function getRecords()
    {
        return SensorAlarm::with('user','sensor.device.check_point.sub_zones','active_alarm')->get();
    }

    public function getRecord($record)
    {
        return [
            $record->user->full_name,
            $record->sensor->device->check_point->sub_zones->first()->name,
            $record->sensor->device->name,
            $record->sensor->name,
            $record->range_min,
            $record->range_max,
            ($record->is_active === 1)?'Si':'No',
            ($record->send_email === 1)?'Si':'No',
            ($record->active_alarm->first())?($record->active_alarm->first()->accused === 1)?'<div class="badge badge-warning">Acusada</div>':'<div class="badge badge-danger">Activa</div>':'Inactiva',
            $this->getOptionButtons($record),
            (optional($record->active_alarm->first())->accused === 1)?'<a href="javascript:void(0);" onclick="confirmAction(\'Realmente desea desmarcar esta alarma como acusada?\',\'/alarm/accused/'.$record->active_alarm->first()->id.'\')" class="btn btn-link">Desacusar</a>':'No Acusada'
        ];
    }

    public function getOptionButtons($record)
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess('sensor-alarms.update')) {
            $update =  makeRemoteLink('/sensor-alarms/'.$record->id.'/edit','Modificar','fa-pencil-alt','btn-warning','btn-sm',true);
        } else {
            $update = '';
        }

        if ($user->hasAccess('sensor-alarms.delete')) {
            $onClick = 'deleteRecord(\'Realmente desea eliminar esta Alarma?\',\'/sensor-alarms/'.$record->id.'\',\'\')';
            $delete = makeLinkOnClick('javascript:void(0);', 'Eliminar', 'fa-trash-alt', 'btn-danger', 'btn-sm', true, $onClick);
        } else {
            $delete = '';
        }

        return makeGroupedLinks([
            makeRemoteLink('sensor-alarm-logs/'.$record->id,'Logs','fa-database','btn-link','btn-sm',true),
            $update,
            $delete
        ]);

    }
}
