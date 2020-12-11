<?php

namespace App\Http\WaterManagement\Dashboard\Alarm\Exports;

use App\Http\WaterManagement\Dashboard\Alarm\Traits\HasAlarmTrait;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;
use Rap2hpoutre\FastExcel\FastExcel;

class ActiveAlarmExportController extends Controller
{
    use HasAlarmTrait;

    public function __invoke(Request $request)
    {
        return (new FastExcel($this->activeAlarmData()))->download("Alarmas Activas-".now()->toDateString().".xlsx", function ($row) {
            return array_combine($this->headers(),$this->map($row));
        });
    }

    protected function headers(): array
    {
        return [
            'Zona',
            'Sub Zona',
            'Punto de Control',
            'Variable',
            'Fecha de Activacion',
            'Valor',
            'Ultimo Valor',
            'Tipo',
            'Acusada',
            'Usuario',
            'Recordarme',
        ];
    }

    public function map($row): array
    {
        switch ($row->type){
            case 1:
                $type= "Bajo";
                break;
            case 2:
                $type= "Alto";
                break;
            case 3:
                $type= "Digital";
                break;
        }

        return [
            $row->zone,
            $row->sub_zone,
            $row->device,
            $row->sensor,
            $row->start_date,
            $row->end_date,
            number_format($row->first_value_readed,2),
            number_format($row->last_value,2),
            $type,
            ($row->accused === 1)? 'Si':'No',
            ($row->accused === 1)? $row->first_name.' '.$row->last_name:'No',
        ];
    }
}
