<?php

namespace App\Exports;

use App\Domain\Data\Analogous\AnalogousReport;
use App\Domain\Data\Digital\DigitalReport;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class ExporDataBySensors implements FromQuery, WithMapping, WithHeadings, WithTitle
{
    use Exportable;

    public  $sensor,$dates,$digital;

    public function __construct($sensor,$dates,$digital = false)
    {
        $this->sensor = $sensor;
        $this->dates = $dates;
        $this->digital = $digital;
    }

    public function map($rows): array
    {
        if ($this->digital) {
            return [
                $rows->sensor->device->check_point->name,
                $rows->sensor->name,
                (string)$rows->value,
                $rows->label,
                Carbon::parse($rows->date)->toDateString(),
                Carbon::parse($rows->date)->format('H:i'),
            ];
        } else {
            if($rows->sensor->type->id === 1 && strtolower($rows->unit) === 'mt') {
                $interpreter = " UBba {$rows->sensor->max_value} MT";
            } else {

                $interpreter = $rows->interpreter;
            }
            $result = $rows->result;
            return [
                $rows->sensor->device->check_point->name,
                $rows->sensor->name,
                number_format($result,2,',',''),
                $rows->unit,
                Carbon::parse($rows->date)->toDateString(),
                Carbon::parse($rows->date)->toTimeString(),
                $interpreter,
            ];
        }

    }

    public function query()
    {
        if($this->digital) {
            $query = DigitalReport::query();
        } else {
            $query = AnalogousReport::query();
        }
        return $this->handleQuery($query
            ->with('sensor.device.check_point.sub_zones')
            ->where('sensor_id',$this->sensor->id)
        )->orderBy('date');
    }

    public function headings(): array
    {
        if($this->digital) {
            return [
                'Punto de Control',
                'Variable',
                'Valor Leído',
                'Etiqueta',
                'Fecha',
                'Hora',
            ];
        } else {
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

    }

    public function title(): string
    {
        if(strlen($this->sensor->device->check_point->name.' - '.$this->sensor->name) > 30) {
            return substr($this->sensor->device->check_point->name,0,15).''.
                substr($this->sensor->name,0,12);
                ;
        } else {
            return $this->sensor->device->check_point->name.' - '.$this->sensor->name;
        }
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
