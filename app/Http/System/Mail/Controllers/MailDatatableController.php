<?php

namespace App\Http\System\Mail\Controllers;

use App\Domain\System\Mail\Mail;
use App\Http\System\DataTable\DataTableAbstract;
use Sentinel;

class MailDatatableController extends DataTableAbstract
{
    public $entity = 'mails';

    public function getRecords()
    {
        return Mail::with(['user','attachables'])->where('user_id',Sentinel::getUser()->id)->orWhere('share_with_all',1)->get();
    }

    public function getRecord($record)
    {
        return [
            $record->user->full_name,
            $record->name,
            $record->subject,
            (implode(', ',$record->attachables->pluck('name')->toArray())) ?? 'Sin conectores',
            makeGroupedLinks([
                makeLink('/mails/'.$record->id.'/edit','Modificar','fa-pencil','btn-secondary','btn-sm',true),
                makeDeleteButton("Realmente desea eliminar el Registro?",$record->id,"'reload'",'',true),
                '<a href="/mail-preview/'.$record->id.'" class="dropdown-item" target="_blank"><i class="fas fa-eye"></i></i> Previsualizar</a>'
            ])
        ];
    }

}
