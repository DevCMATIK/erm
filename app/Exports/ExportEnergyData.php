<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ExportEnergyData implements WithMultipleSheets
{
    use Exportable;

    public $sensors,$dates;

    public function __construct($sensors,$dates)
    {
        $this->sensors = $sensors;
        $this->dates = $dates;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];

        foreach($this->sensors as $sensor) {
            $sheets[] = new ExportVariablesData($sensor->device_id,$sensor,$this->dates);
        }

        return $sheets;
    }
}

