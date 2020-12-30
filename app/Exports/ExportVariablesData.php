<?php

namespace App\Exports;

use App\Domain\Data\Analogous\AnalogousReport;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ExportVariablesData implements FromQuery, WithMapping, WithHeadings, WithTitle
{
    use Exportable;

    public $device, $sensor,$dates;

    public function __construct($device,$sensor,$dates)
    {
        $this->device = $device;
        $this->sensor = $sensor;
        $this->dates = $dates;
    }

    public function map($rows): array
    {
        if($rows->sensor->type->id === 1 && strtolower($rows->unit) === 'mt') {
            $interpreter = " UBba {$rows->sensor->max_value} MT";
        } else {

            $interpreter = $rows->interpreter;
        }
            return [
                $rows->sensor->device->name,
                $rows->sensor->name,
                $rows->result,
                $rows->unit,
                Carbon::parse($rows->date)->toDateString(),
                Carbon::parse($rows->date)->format('H:i'),
                $interpreter,
            ];
    }

    public function query()
    {
        return $this->handleQuery(AnalogousReport::query()
            ->with([
                'sensor.device.check_point.sub_zones',
                'sensor.type'
            ])
            ->where('device_id',$this->device)
            ->where('sensor_id',$this->sensor->id)
        )->orderBy('date');
    }

    public function headings(): array
    {
        return [
            'Punto de Control',
            'Variable',
            'Valor Leído',
            'Unidad',
            'Fecha',
            'Hora',
            'Descripción',
        ];
    }

    public function title(): string
    {
        return $this->sensor->name;
    }

    protected function handleQuery($query)
    {

        $dates = explode(' ',$this->dates);
        $from = date($dates[0]);
        $to = date($dates[2]);
        $from = Carbon::parse($from)->startOfDay()->toDateTimeString();  //2016-09-29 00:00:00.000000
        $to = Carbon::parse($to)->endOfDay()->toDateTimeString();
        $query = $query->between('date',$from,$to);



        return $query;
    }
}
