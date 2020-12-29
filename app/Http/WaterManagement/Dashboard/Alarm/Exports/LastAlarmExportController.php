<?php

namespace App\Http\WaterManagement\Dashboard\Alarm\Exports;

use App\Http\WaterManagement\Dashboard\Alarm\Traits\HasAlarmTrait;
use App\Http\WaterManagement\Dashboard\Alarm\Traits\HasAuditTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;
use Rap2hpoutre\FastExcel\FastExcel;

class LastAlarmExportController extends Controller
{
    use HasAlarmTrait;

    public function __invoke(Request $request)
    {
        return (new FastExcel($this->getLastAlarmsWithParameters($request)->get()))->download("ultimas-alarmas-".now()->toDateString().".xlsx", function ($row) {
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
            'Tipo',
            'Fecha de Activacion',
            'Fecha de Termino',
            'Duracion',
            'Valor',
            'Ultimo Valor',
            'Acusada',
            'Acusada por',
            'Fecha de Acuse',
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
            $type,
            $row->start_date,
            $row->end_date,
            Carbon::parse($row->start_date)->diff(Carbon::parse($row->end_date) ?? Carbon::now())->format('%H:%I:%S'),
            number_format($row->first_value_readed,2),
            number_format($row->last_value,2),
            ($row->accused === 1)? 'Si':'No',
            ($row->accused === 1)? $row->first_name.' '.$row->last_name:'N/A',
            ($row->accused_at)?? 'No Acusada',
        ];
    }
}
