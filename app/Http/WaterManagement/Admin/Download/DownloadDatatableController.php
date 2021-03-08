<?php

namespace App\Http\WaterManagement\Admin\Download;

use App\Domain\Data\Export\ExportReminder;
use App\Http\System\DataTable\DataTableAbstract;
use Illuminate\Http\Request;

class DownloadDatatableController extends DataTableAbstract
{
    public function getRecords()
    {
        return ExportReminder::with([
            'user',
            'files'
        ])->orderBy('creation_date','desc')->get();
    }

    public function getRecord($record)
    {
        $links = array();


        return [
            $record->creation_date,
            $record->user->full_name,
            makeLink('/descargar-archivos/'.$record->id,'('.$record->files->unique('display_name')->count().') Ver archivos','fa-file-excel','btn-link','btn-sm'),
            $record->from,
            $record->to
        ];
    }
}
