<?php

namespace App\Http\WaterManagement\Dashboard\Chart;

use App\Domain\WaterManagement\Sensor\Consumption\WaterConsumption;
use Carbon\Carbon;
use App\App\Controllers\Controller;
use Rap2hpoutre\FastExcel\FastExcel;

class ExportWaterConsumptionData extends Controller
{
    public function __invoke($sensor_id)
    {
        return (new FastExcel($this->query($sensor_id)->get()))->download("Consumo Agua-".now()->toDateString().".xlsx", function ($row) {
            return array_combine($this->headers(),$this->map($row));
        });
    }

    protected function query($sensor)
    {
        return WaterConsumption::with(['sub_zone','sensor'])->where('sensor_id',$sensor);
    }

    protected function map($row)
    {
        return [
            $row->sub_zone->name,
            $row->sensor->name,
            $row->consumption,
            $row->first_read,
            $row->last_read,
            'M3',
            $row->sensor_type,
            Carbon::parse($row->date)->toDateString()
        ];
    }

    protected function headers(): array
    {
        return [
            'Sub Zona',
            'Sensor',
            'Consumo',
            'Primera Lectura',
            'Última Lectura',
            'Unidad',
            'Tipo Sensor',
            'Fecha',
        ];
    }

}
