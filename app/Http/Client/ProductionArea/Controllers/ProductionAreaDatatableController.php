<?php

namespace App\Http\Client\ProductionArea\Controllers;



use App\Domain\Client\ProductionArea\ProductionArea;
use App\Http\System\DataTable\DataTableAbstract;

class ProductionAreaDatatableController extends DataTableAbstract
{
    public $entity = 'production-areas';

    public function getRecords()
    {
        return ProductionArea::get();
    }

    public function getRecord($record)
    {
        return [
            $record->name,
            $this->getOptionButtons($record->id)
        ];
    }

    public function getOptionButtons($id)
    {
        return makeGroupedLinks(array_merge($this->getDefaultOptions($id),[
            makeRemoteLink('/productionArea/zones/'.$id,'Zonas','fa-sitemap','','',true)
        ]));
    }
}
