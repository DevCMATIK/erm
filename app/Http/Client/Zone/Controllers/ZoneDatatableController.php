<?php

namespace App\Http\Client\Zone\Controllers;


use App\Domain\Client\Zone\Zone;
use App\Http\System\DataTable\DataTableAbstract;

class ZoneDatatableController extends DataTableAbstract
{
    public $entity = 'zones';

    public function getRecords()
    {
        return Zone::withCount('sub_zones')->get();
    }

    public function getRecord($record)
    {
        return [
            $record->name,
            $record->display_name,
            $record->sub_zones_count,
            $this->getOptionButtons($record)
        ];
    }

    public function getOptionButtons($record)
    {
       return makeGroupedLinks(
           array_merge(
                $this->getDefaultOptions($record->id),[
                makeLink("/sub-zones?zone={$record->slug}","Sub Zonas ({$record->sub_zones_count})",'fa-sitemap','btn-primary','btn-md','true'),
                makeRemoteLink("/sub-zones/create?zone={$record->slug}","Crear sub zona",'fa-plus','btn-primary','btn-md','true'),
                makeRemoteLink("/subZoneSerialization/{$record->id}","Reordernar Sub zonas",'fa-list-ol','btn-primary','btn-md','true')
       ]));
    }
}
