<?php

namespace App\Http\Client\Area\Controllers;

use App\Domain\Client\Area\Area;
use App\Http\System\DataTable\DataTableAbstract;

class AreaDatatableController extends DataTableAbstract
{
    public $entity = 'areas';

    public function getRecords()
    {
        return Area::with('zones')->get();
    }

    public function getRecord($record)
    {
        return [
            $record->name,
            $record->zones->implode('name',', '),
            '<i class="fas '.$record->icon.'"></i>',
            $this->getOptionButtons($record->id)
        ];
    }

    public function getOptionButtons($id)
    {
        return makeGroupedLinks(
            array_merge(
                $this->getDefaultOptions($id),[
                makeRemoteLink("/area-zones/{$id}","Zonas",'fa-sitemap','btn-primary','btn-md','true')
            ]));
    }
}
