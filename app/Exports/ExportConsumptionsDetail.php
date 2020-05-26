<?php

namespace App\Exports;

use App\Domain\WaterManagement\Device\Sensor\Electric\ElectricityConsumption;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class ExportConsumptionsDetail implements  FromQuery, WithMapping, WithHeadings, WithTitle
{
    use Exportable;

    public $sub_zone;

    public function __construct($sub_zone)
    {
        $this->sub_zone = $sub_zone;
    }

    public function map($rows): array
    {
        return [
            $rows->consumption,
            $rows->first_read,
            $rows->last_read,
            'Kwh',
            $rows->sensor_type,
            Carbon::parse($rows->date)->toDateString()
        ];
    }

    public function query()
    {
        return ElectricityConsumption::query()->where('sub_zone_id',$this->sub_zone->id)->orderBy('date');
    }

    public function headings(): array
    {
        return [
            'Consumo',
            'Primera lectura',
            'última Lectura',
            'Unidad',
            'Sensor',
            'Fecha'
        ];
    }

    public function title(): string
    {
        return $this->sub_zone->name;
    }


}
