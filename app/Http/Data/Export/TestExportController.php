<?php

namespace App\Http\Data\Export;

use App\Domain\Data\Analogous\AnalogousReport;
use App\Domain\WaterManagement\Device\Sensor\Sensor;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;
use Carbon\Carbon;
use Rap2hpoutre\FastExcel\FastExcel;

class TestExportController extends Controller
{
    public function __invoke(Request $request)
    {
        $dates = $this ->resolveDates($request->dates);
        $sensors  = $this-> getSensors($request->sensors);
        $sensor = $sensors -> first();//deberia ser un foreach por cada sensor y guardarlo en hojas distintas

        return (new FastExcel($this->query($sensor,$dates)->get()))
                ->download('descarga-del-sensor.xlsx',
                        function($row) {
                            return array_combine($this->getHeaders(),$this->resolveRow($row));
                        }
                );
        //dd($request,$dates,$sensors);
    }

    protected function getSensors($sensors)
    {
         return Sensor::with([
            'type',
            'device.check_point'
        ])->whereIn('id',$sensors)->get();
    }

    protected function resolveDates ($dates)
    {
        $dates = explode(' ',$dates);
        $from = date($dates[0]);
        $to = date($dates[2]);

        return [
           'from'=> Carbon::parse($from)->startOfDay()->toDateTimeString(),
           'to'=>Carbon::parse($to)->endOfDay()->toDateTimeString(),
        ];
    }

    protected function query($sensor,$dates)
    {
        return $this->resolveDatesQuery(
            AnalogousReport::query()
                ->with([
                'sensor.device.check_point.sub_zones',
                'sensor.type'
                 ])
                ->where('sensor_id',$sensor->id),
            $dates
        )->orderBy('date');
    }

    protected function getHeaders(): array
    {
        return [
            'Punto de Control',//=>$puntoControl
            'Variable',
            'Valor Leído',
            'Unidad',
            'Fecha',
            'Hora',
            'Descripción',
        ];
    }

    public function resolveRow($row): array
    {
        if($row->sensor->type->id === 1 && strtolower($row->unit) === 'mt') {
            $interpreter = " UBba {$row->sensor->max_value} MT";
        } else {

            $interpreter = $row->interpreter;
        }
        $result = number_format($row->result,2,',','');
        return [
            $row->sensor->device->name,
            $row->sensor->name,
            $result,
            $row->unit,
            Carbon::parse($row->date)->toDateString(),
            Carbon::parse($row->date)->format('H:i'),
            $interpreter,
        ];
    }

    protected function resolveDatesQuery($query,$dates)
    {
        return $query->whereRaw ("`date` between '{$dates['from']}' and '{$dates['to']}'");
    }
}
