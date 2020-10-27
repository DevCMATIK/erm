<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ExportChartDataWithSheets implements WithMultipleSheets
{
    use Exportable;

    public $device, $sensors,$dates;

    public function __construct($device,$sensors,$dates)
    {
        $this->device = $device;
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
            $sheets[] = new ExportVariablesData($this->device,$sensor,$this->dates);
        }

        return $sheets;
    }
}
