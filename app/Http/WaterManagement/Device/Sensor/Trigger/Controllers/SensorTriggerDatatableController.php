<?php

namespace App\Http\WaterManagement\Device\Sensor\Trigger\Controllers;

use App\Domain\WaterManagement\Device\Sensor\Trigger\SensorTrigger;
use App\Http\System\DataTable\DataTableAbstract;
use Carbon\Carbon;


class SensorTriggerDatatableController extends DataTableAbstract
{
    public $entity = 'sensor-triggers';

    public function getRecords()
    {
        return SensorTrigger::with(['receptor.device','user'])
            ->where('sensor_id',$this->filter)
            ->get();
    }

    public function getRecord($record)
    {
        return [
            $record->user->first_name.' '.$record->user->last_name,
            $record->receptor->name.' Dispositivo: '.$record->receptor->device->name,
            $record->when_one,
            $record->when_zero,
            $record->range_min,
            $record->range_max,
            $record->in_range,
            $record->minutes.' minuto(s)',
            ($record->is_active === 1)?'Activo':'Inactivo',
            ($record->last_execution)?Carbon::parse($record->last_execution)->diffForHumans(): 'No ejecutado',
            $this->getOptionButtons($record)
        ];
    }

    public function getOptionButtons($record)
    {
        $active = ($record->is_active === 1)?0:1;
        $label = ($record->is_active === 1)?'Desactivar':'activar';
        return makeGroupedLinks(array_merge(
            $this->getDefaultOptions($record->id),
            [makeLink("/triggerActive/{$record->id}/".$active,$label,'fa-eye','btn-primary','btn-sm',true)]
        ));
    }

}
