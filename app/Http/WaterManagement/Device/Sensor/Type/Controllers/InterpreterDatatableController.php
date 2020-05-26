<?php

namespace App\Http\WaterManagement\Device\Sensor\Type\Controllers;

use App\Domain\WaterManagement\Device\Sensor\Type\Interpreter;
use App\Http\System\DataTable\DataTableAbstract;

class InterpreterDatatableController extends DataTableAbstract
{
    public $entity = 'interpreters';

    public function getRecords()
    {
        return Interpreter::where('type_id',$this->filter)->get();
    }

    public function getRecord($record)
    {
        return [
            $record->value,
            $record->name,
            $record->description,
            $this->getOptionButtons($record->id)
        ];
    }
}
