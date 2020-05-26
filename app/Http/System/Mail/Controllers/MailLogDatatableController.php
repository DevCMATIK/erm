<?php

namespace App\Http\System\Mail\Controllers;

use App\Domain\System\Mail\MailLog;
use App\Http\System\DataTable\DataTableAbstract;

class MailLogDatatableController extends DataTableAbstract
{
    public $entity = 'mail-logs';

    public function getRecords()
    {
        return MailLog::with('mail')->withCount('users')->get();
    }

    public function getRecord($record)
    {
        return [
            optional($record->mail)->name ?? 'correo de sistema',
            $record->identifier,
            $record->date,
            makeRemoteLink('/mail-logs/'.$record->id,'receptores('.$record->users_count.')','fa-users','btn-info','btn-xs')
        ];
    }
}
