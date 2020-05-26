<?php

namespace App\Http\Client\CheckPoint\Report\Controllers;

use App\Domain\Client\CheckPoint\DGA\CheckPointReport;
use App\Http\System\DataTable\DataTableAbstract;

class CheckPointReportLogDatatableController extends DataTableAbstract
{
    public function getRecords()
    {
        return CheckPointReport::where('check_point_id',$this->filter)->orderBy('report_date','desc')->get();
    }

    public function getRecord($record)
    {
        return [
            $record->response,
            $record->response_text,
            number_format($record->tote_reported,0,',','').' m3',
            number_format($record->flow_reported,2,',',''). ' l/s',
            number_format($record->water_table_reported ,2,',','').' mt',
            $record->report_date
        ];
    }
}
