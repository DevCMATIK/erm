<?php

namespace App\Exports;

use App\Domain\Client\Zone\Sub\SubZone;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ExportConsumptions implements WithMultipleSheets
{
    use Exportable;

    public $sub_zone;
    public $request;

    public function __construct($sub_zone,$request)
    {
        $this->sub_zone = SubZone::with('zone')->find($sub_zone);
        $this->request = $request;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];

        $sheets[0] = new ExportConsumptionsDetail($this->sub_zone,$this->request);
        $sheets[1] = new ExportConsumptionsTotal($this->sub_zone,$this->request);


        return $sheets;
    }
}
