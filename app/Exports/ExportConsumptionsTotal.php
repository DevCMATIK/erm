<?php

namespace App\Exports;

use App\Domain\Client\Zone\Sub\SubZone;
use App\Domain\WaterManagement\Device\Sensor\Electric\ElectricityConsumption;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class ExportConsumptionsTotal implements  FromQuery, WithMapping, WithHeadings, WithTitle
{
    use Exportable;

    public $sub_zone,$zone;

    public function __construct($sub_zone)
    {
        $this->sub_zone = $sub_zone;
        $this->zone = $sub_zone->zone;
    }

    public function map($rows): array
    {
        return [
            $rows->sub_zone->name,
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
        $sub_zones_id = SubZone::where('zone_id',$this->sub_zone->zone_id)->get()->pluck('id')->toArray();
        return ElectricityConsumption::query()->with('sub_zone')->whereIn('sub_zone_id',$sub_zones_id)->orderBy('date');
    }

    public function headings(): array
    {
        return [
            'Sub Zona',
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
        return 'Zona '.$this->zone->name;
    }


}
