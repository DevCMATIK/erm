<?php

namespace App\Http\Client\CheckPoint\Controllers;

use App\Domain\Client\CheckPoint\CheckPoint;
use App\Domain\Client\CheckPoint\Type\CheckPointType;
use App\Http\System\DataTable\DataTableAbstract;

class CheckPointDatatableController extends DataTableAbstract
{
    public $entity = 'check-points';

    public function getRecords()
    {
        $type = CheckPointType::findBySlug($this->filter);
        return CheckPoint::with('type','sub_zones')->withCount('devices')->where('type_id', $type->id)->get();
    }

    public function getRecord($record)
    {
        return [
            $record->type->name,
            $record->name,
            implode(',<br>',$record->sub_zones->pluck('name')->toArray()),
            $record->devices_count,
            $this->getOptionButtons($record)
        ];
    }

    public function getOptionButtons($record)
    {
        return makeGroupedLinks(
            array_merge(
                $this->getDefaultOptions($record->id),[
                makeLink("/devices?check_point_id={$record->id}","Dispositivos ({$record->devices_count})",'fa-sitemap','btn-primary','btn-md','true')
            ]));
    }
}
