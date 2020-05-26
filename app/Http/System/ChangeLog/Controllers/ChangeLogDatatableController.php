<?php

namespace App\Http\System\ChangeLog\Controllers;

use App\Domain\System\ChangeLog\ChangeLog;
use App\Http\System\DataTable\DataTableAbstract;

class ChangeLogDatatableController extends DataTableAbstract
{
    public $entity = 'change-logs';

    public function getRecords()
    {
        return ChangeLog::with('user')->orderBy('id','desc')->get();
    }

    public function getRecord($record)
    {
        $old = '';
        if(isset($record->old_columns) && $record->old_columns != '') {

            foreach(json_decode($record->old_columns) as $key => $value) {
            if(!is_array($value)) {
                dd($old.$key.': '.$value.'<br>');
                $old = $old.$key.': '.$value.'<br>';
            }

        }
        }

        $new = '';
        if(isset($record->new_columns) && $record->new_columns != '') {
            foreach(json_decode($record->new_columns) as $key => $value) {
                if(!is_array($value)) {
                    $new = $new.$key.': '.$value.'<br>';
                }

            }
        }

        return [
            $record->user->full_name,
            $record->description,
            $record->table,
            $old,
            $new,
            $record->date
        ];
    }
}
