<?php

namespace App\Http\WaterManagement\Report\Controllers;

use App\Domain\WaterManagement\Report\MailReport;
use App\Http\System\DataTable\DataTableAbstract;


class MailReportDatatableController extends DataTableAbstract
{
    public $entity = 'mail-reports';

    public function getRecords()
    {
        return MailReport::with(['groups','sensors','user','mail'])->get();
    }

    public function getRecord($record)
    {
        return [
            $record->name,
            $record->mail->name,
            $record->groups->implode('name',', '),
            $record->user->full_name,
            $record->frequency,
            $record->start_at,
            ($record->is_active === 1)?'Activo':'Inactivo',
            $record->last_execution ?? 'No Ejecutado',
            $this->getOptionButtons($record)
        ];
    }

    public function getOptionButtons($record)
    {
        $active = ($record->is_active === 1)?0:1;
        $label = ($record->is_active === 1)?'Desactivar':'activar';
        return makeGroupedLinks(array_merge(
            $this->getDefaultOptions($record->id),
            [makeLink("/mail-reportActive/{$record->id}/".$active,$label,'fa-eye','btn-primary','btn-sm',true),
            makeRemoteLink("/mailReportSerialization/{$record->id}",'Serializar','fa-list-ol','btn-primary','btn-sm',true)]
        ));
    }
}
