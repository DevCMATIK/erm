<?php

namespace App\Http\Client\CheckPoint\Report\Controllers;

use App\Domain\Client\CheckPoint\CheckPoint;
use App\Http\System\DataTable\DataTableAbstract;

class CheckPointReportDatatableController extends DataTableAbstract
{
    public function getRecords()
    {
        return CheckPoint::with(['type','sub_zones'])->withCount('dga_reports')->whereNotNull('work_code')->get();
    }

    public function getRecord($record)
    {
        return [
            $record->name,
            $record->type->name,
            $record->sub_zones->first()->name,
            $record->dga_reports_count,
            makeGroupedLinks([
                makeRemoteLink('/check-point/dga_reports/'.$record->id,'Log','fa-database','btn-link','btn-sm',true),
                makeLink('/check-point/dga_reports/download/'.$record->id,'Descargar','fa-file-excel','btn-link','btn-sm',true)
            ])
        ];
    }
}
