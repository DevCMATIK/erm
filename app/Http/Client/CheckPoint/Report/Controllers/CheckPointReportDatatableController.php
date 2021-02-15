<?php

namespace App\Http\Client\CheckPoint\Report\Controllers;

use App\Domain\Client\CheckPoint\CheckPoint;
use App\Http\System\DataTable\DataTableAbstract;
use Carbon\Carbon;
use Sentinel;

class CheckPointReportDatatableController extends DataTableAbstract
{
    public function getRecords()
    {
        return CheckPoint::with(['type','sub_zones'])->withCount(['dga_reports','this_month_failed_reports','reports_to_date'])->whereNotNull('work_code')->get();
    }

    public function getRecord($record)
    {
        $user = Sentinel::getUser();
        switch($record->dga_report) {
            case 1:
                $frequency = 'Cada hora';
                $max = 24;
                break;
            case 2 :
                $frequency = 'Cada día';
                $max = 1;
                break;
            case 3:
                $frequency = 'Cada mes';
                $max = 0;
                break;
            default:
                $frequency = 'Cada año';
                $max = 0;
                break;
        }

        if($record->this_month_failed_reports_count > 0){
            $status = '<label class="badge badge-danger badge-pill p-1">Error</label>';
        } else {
            $diff = Carbon::now()->startOfMonth()->diffInDays(Carbon::now()) * $max;
            if($max == 0){
                $status = '<label class="badge badge-success badge-pill p-1">OK</label>';
            } else {
                if($record->reports_to_date_count == $diff) {
                    $status = '<label class="badge badge-success badge-pill p-1">OK</label>';
                } else {
                    $status = '<label class="badge badge-danger badge-pill p-1">Error</label>';
                }
            }
        }

        return [
            $record->name,
            $record->work_code,
            $frequency,
            $record->sub_zones->first()->name,
            $record->dga_reports_count,
            $status,
            ($user->hasAnyAccess(['dga.logs','dga.status','dga.export']))?makeGroupedLinks([
                ($user->hasAccess('dga.logs'))?makeRemoteLink('/check-point/dga_reports/'.$record->id,'Log','fa-database','btn-link','btn-sm',true):'',
                ($user->hasAccess('dga.status'))?makeLink('/check-point/dga_reports_statistics/'.$record->id,'Status','fa-check','btn-link','btn-sm',true):'',
                ($user->hasAccess('dga.export'))?makeLink('/check-point/dga_reports/download/'.$record->id,'Descargar','fa-file-excel','btn-link','btn-sm',true):''
            ]):'-'
        ];
    }
}
