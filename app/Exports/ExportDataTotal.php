<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ExportDataTotal implements WithMultipleSheets
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

        foreach($this->sensors->unique() as $sensor) {
            if(optional($sensor->label)->name) {
                $digital = true;
            } else {
                $digital = false;
            }
            $sheets[] = new ExporDataBySensors($sensor,$this->dates,$digital);
        }

        return $sheets;
    }
}
