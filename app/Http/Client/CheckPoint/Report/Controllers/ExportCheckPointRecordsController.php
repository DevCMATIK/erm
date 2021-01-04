<?php

namespace App\Http\Client\CheckPoint\Report\Controllers;

use App\Domain\Client\CheckPoint\CheckPoint;
use App\Domain\Client\CheckPoint\DGA\CheckPointReport;
use App\Domain\WaterManagement\Sensor\Consumption\WaterConsumption;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;
use Rap2hpoutre\FastExcel\FastExcel;

class ExportCheckPointRecordsController extends Controller
{
    public function __invoke($check_point_id)
    {
        $check_point = CheckPoint::find($check_point_id);
        return (new FastExcel($this->query($check_point_id)->get()))->download("Reportes-DGA-".$check_point->name.'-'.now()->toDateString().".xlsx", function ($row) {
            return array_combine($this->headers(),$this->map($row));
        });
    }

    protected function query($id)
    {
        return CheckPointReport::with('check_point')->where('check_point_id',$id);
    }

    protected function map($row)
    {
        return [
            $row->check_point->name,
            $row->response_text,
            number_format($row->tote_reported,0,'.',''),
            'm3',
            number_format($row->flow_reported,2,'.',''),
            'l/s',
            number_format($row->water_table_reported ,2,'.',''),
            'mt',
            Carbon::parse($row->report_date)->toDateString(),
            Carbon::parse($row->report_date)->toTimeString(),
        ];
    }

    protected function headers(): array
    {
        return [
            'Punto de control',
            'Respuesta desde DGA',
            'Totalizador',
            'Un. Totalizador',
            'Caudal',
            'Un. Caudal',
            'Nivel',
            'Un. Nivel',
            'Fecha',
            'Hora',
        ];
    }
}
