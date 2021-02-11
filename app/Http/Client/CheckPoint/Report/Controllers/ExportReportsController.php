<?php

namespace App\Http\Client\CheckPoint\Report\Controllers;

use App\Domain\Client\CheckPoint\CheckPoint;
use App\Domain\Client\CheckPoint\DGA\CheckPointReport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;
use Rap2hpoutre\FastExcel\FastExcel;
use Rap2hpoutre\FastExcel\SheetCollection;

class ExportReportsController extends Controller
{
    public function __invoke()
    {
        $check_points = CheckPoint::whereNotNull('work_code')->get();
        $data =array();
        $sheetsName =array();
        foreach($check_points as $check_point) {
            array_push($sheetsName,$check_point->name);
            array_push($data,$this->mapQuery($check_point));
        }

        $sheets = new SheetCollection(array_combine($sheetsName,$data));
        return (new FastExcel($sheets))->download('Data-Reportes-'.Carbon::today()->toDateString().'.xlsx');
    }

    protected function query($id)
    {
        return CheckPointReport::with('check_point')->where('check_point_id',$id);
    }

    protected function mapQuery($check_point)
    {
        return $this->query($check_point->id)-> get()->map(function($item){
            return array_combine($this->headers(),$this->map($item));
        });
    }

    protected function map($row)
    {
        return [
            $row->check_point->name,
            $row->check_point->work_code,
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
            'Código de Obra',
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
