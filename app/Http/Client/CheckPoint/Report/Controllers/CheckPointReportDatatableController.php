<?php

namespace App\Http\Client\CheckPoint\Report\Controllers;

use App\Domain\Client\CheckPoint\CheckPoint;
use App\Http\System\DataTable\DataTableAbstract;
use Sentinel;

class CheckPointReportDatatableController extends DataTableAbstract
{
    public function getRecords()
    {
        return CheckPoint::with(['type','sub_zones'])->withCount('dga_reports')->whereNotNull('work_code')->get();
    }

    public function getRecord($record)
    {
        $user = Sentinel::getUser();
        switch($record->dga_report) {
            case 1:
                $frequency = 'Cada hora';
                break;
            case 2 :
                $frequency = 'Cada día';
                break;
            case 3:
                $frequency = 'Cada mes';
                break;
            default:
                $frequency = 'Cada año';
                break;
        }
        return [
            $record->name,
            $record->work_code,
            $frequency,
            $record->sub_zones->first()->name,
            $record->dga_reports_count,
            ($user->hasAnyAccess(['dga.logs','dga.status','dga.export']))?makeGroupedLinks([
                ($user->hasAccess('dga.logs'))?makeRemoteLink('/check-point/dga_reports/'.$record->id,'Log','fa-database','btn-link','btn-sm',true):'',
                ($user->hasAccess('dga.status'))?makeLink('/check-point/dga_reports_statistics/'.$record->id,'Status','fa-check','btn-link','btn-sm',true):'',
                ($user->hasAccess('dga.export'))?makeLink('/check-point/dga_reports/download/'.$record->id,'Descargar','fa-file-excel','btn-link','btn-sm',true):''
            ]):'-'
        ];
    }
}
