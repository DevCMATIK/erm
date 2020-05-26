<?php

namespace App\Http\WaterManagement\Device\Controllers;

use App\Domain\WaterManagement\Device\Device;
use App\Http\System\DataTable\DataTableAbstract;

class DeviceDatatableController extends DataTableAbstract
{
    public $entity = 'devices';

    public function getRecords()
    {
        return Device::with('type')
            ->withCount('sensors')
            ->where('check_point_id',$this->filter)
            ->get();
    }

    public function getRecord($record)
    {
        return [
            $record->internal_id,
            $record->name,
            $record->type->name,
            $this->getOptionButtons($record)
        ];
    }

    public function getOptionButtons($record)
    {
        return makeGroupedLinks(
            array_merge(
                $this->getDefaultOptions($record->id),[
                makeLink("/sensors?device_id={$record->id}","Sensores ({$record->sensors_count})",'fa-sitemap','btn-primary','btn-md','true'),
                makeRemoteLink('/device-disconnections/'.$record->id,'Desconexiones','fa-database','btn-link','btn-sm',true)

            ]));
    }
}
