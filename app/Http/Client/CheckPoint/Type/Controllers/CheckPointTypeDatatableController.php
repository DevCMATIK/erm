<?php

namespace App\Http\Client\CheckPoint\Type\Controllers;

use App\Domain\Client\CheckPoint\Type\CheckPointType;
use App\Http\System\DataTable\DataTableAbstract;

class CheckPointTypeDatatableController extends DataTableAbstract
{
    public $entity = 'check-point-types';

    public function getRecords()
    {
        return CheckPointType::withCount('check_points')->get();
    }

    public function getRecord($record)
    {
        return [
            $record->name,
            $record->check_points_count,
            $this->getOptionButtons($record)
        ];
    }

    public function getOptionButtons($record)
    {
        return makeGroupedLinks(
            array_merge(
                $this->getDefaultOptions($record->id),[
                makeLink("/check-points?type={$record->slug}","Puntos de Control ({$record->check_points_count})",'fa-sitemap','btn-primary','btn-md','true')
            ]));
    }
}
