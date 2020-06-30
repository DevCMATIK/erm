<?php

namespace App\Http\WaterManagement\Device\Sensor\Trigger\Controllers;

use App\Domain\WaterManagement\Device\Sensor\Trigger\SensorTrigger;
use App\Http\System\DataTable\DataTableAbstract;
use Carbon\Carbon;
use Sentinel;

class SensorTriggerListDatatableController extends DataTableAbstract
{
    public $entity = 'triggers-list';

    public function getRecords()
    {
        return SensorTrigger::with(['receptor.device','user','sensor.device.check_point.sub_zones'])
            ->get();
    }

    public function getRecord($record)
    {
        return [
            $record->user->first_name.' '.$record->user->last_name,
            $record->sensor->device->check_point->sub_zones->first()->name,
            optional(optional($record->receptor)->device)->name.' - '.optional($record->receptor)->name,
            $record->sensor->device->name.' - '.$record->sensor->name,
            $record->when_one,
            $record->when_zero,
            $record->range_min,
            $record->range_max,
            $record->in_range,
            $record->minutes.' minuto(s)',
            ($record->last_execution)?Carbon::parse($record->last_execution)->diffForHumans(): 'No ejecutado',
            $this->getOptionButtons($record)
        ];
    }

    public function getOptionButtons($record)
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess('sensor-triggers.update')) {
            $update =  makeRemoteLink('/sensor-triggers/'.$record->id.'/edit','Modificar','fa-pencil-alt','btn-warning','btn-sm',true);
        } else {
            $update = '';
        }

        if ($user->hasAccess('sensor-triggers.delete')) {
            $onClick = 'deleteRecord(\'Realmente desea eliminar este trigger?\',\'/sensor-triggers/'.$record->id.'\',\'\')';
            $delete = makeLinkOnClick('javascript:void(0);', 'Eliminar', 'fa-trash-alt', 'btn-danger', 'btn-sm', true, $onClick);
        } else {
            $delete = '';
        }
        $active = ($record->is_active === 1)?0:1;
        $label = ($record->is_active === 1)?'Desactivar':'activar';
        return makeGroupedLinks([
            makeRemoteLink('/triggerLog/'.$record->id,'Log', 'fa-database','btn-link','btn-sm',true),
            $update,
            $delete,
            makeLink("/triggerActive/{$record->id}/".$active,$label,'fa-eye','btn-primary','btn-sm',true)
        ]);
    }
}
