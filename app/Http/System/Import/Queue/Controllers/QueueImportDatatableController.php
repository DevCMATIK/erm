<?php

namespace App\Http\System\Import\Queue\Controllers;


use App\Domain\System\Import\Import;
use App\Domain\System\Import\QueuedImport;
use App\Http\System\DataTable\DataTableAbstract;
use Sentinel;

class QueueImportDatatableController extends DataTableAbstract
{
    public function getRecords()
    {
        return QueuedImport::where('user_id',Sentinel::getUser()->id)->get();
    }

    public function getRecord($record)
    {
        return [
            $record->name,
            implode(',',Import::find(json_decode($record->imports))->pluck('name')->toArray()),
            $this->getOptionButtons($record->id)
        ];
    }

    public function getOptionButtons($id)
    {
        $user = Sentinel::getUser();
        $buttons = array();
        if (Sentinel::getUser()->hasAnyAccess(['queuedImports.update','queuedImports.delete','queuedImports.serialize'])) {
            $buttons = [
                makeEditButton($id,'',true,true),
                makeDeleteButton("Realmente desea eliminar esta sequencia?",$id,"'reload'",'',true),
            ];

            if ($user->hasAccess('queuedImports.serialize')) {
                array_push(
                    $buttons,
                    makeRemoteLink('/serializeQueuedImport/'.$id,'Serializar','fa-list-ol','','',true)
                );
            }
            return makeGroupedLinks($buttons);
        } else {
            return '-';
        }
    }
}
