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
        foreach($record->files as $file) {
            array_push($links,
                makeLink('https://erm.cmatik.app/download-file/'.$file->id,$file->display_name,'fa-file-excel','btn-link','btn-sm')
            );
        }

        return [
            $record->creation_date,
            $record->user->full_name,
            implode('<br>',$links),
            $record->from,
            $record->to
        ];
    }
}
