<?php

namespace App\Http\Watermanagement\Dashboard\Chart;

use App\Domain\Data\Analogous\AnalogousReport;
use App\Domain\Data\Digital\DigitalReport;
use App\Domain\Data\Export\ExportReminder;
use App\Domain\WaterManagement\Device\Sensor\Sensor;
use App\Exports\ExportChartDataWithSheets;
use App\Http\Data\Export\ExportDataWithBox;
use App\Http\Data\Jobs\Export\CreateFileForSensor;
use App\Http\Data\Jobs\Export\ExportDataBySensor;
use App\Http\Data\Jobs\Export\SendMailExportCompleted;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;
use Sentinel;

use Rap2hpoutre\FastExcel\FastExcel;
use Rap2hpoutre\FastExcel\SheetCollection;

class ExportDataTotal extends Controller
{
    public $is_digital;
    public function __invoke(Request $request)
    {

        $ss = array_unique($request->sensors);

        $sensors  = Sensor::with([
            'type',
            'device.check_point'
        ])->whereIn('id',$ss)->get();

        $dates = explode(' ',$request->dates);
        $from = date($dates[0]);
        $to = date($dates[2]);
        $from = Carbon::parse($from)->startOfDay();  //2016-09-29 00:00:00.000000
        $to = Carbon::parse($to)->endOfDay();
        if($to->diffInDays($from) > 30 || count($sensors) >= 5) {
            $reminder = ExportReminder::create([
                'user_id' => Sentinel::getUser()->id,
                'sensors' => $sensors->pluck('id')->implode(','),
                'from' => $from,
                'to' => $to,
                'creation_date' => Carbon::now()->toDateTimeString(),
                'expires_at' => Carbon::tomorrow()->toDateString()
            ]);
            $user_id = Sentinel::getUser()->id;
            $jobs = $sensors->unique()->map(function($item) use($from,$to,$user_id,$reminder){
                return new CreateFileForSensor($item,$from,$to,$user_id,$reminder);
            })->toArray();
            ExportDataBySensor::withChain(
                array_merge(
                    $jobs,
                    [ new SendMailExportCompleted(Sentinel::getUser(),$reminder)]
                )
            )->dispatch()
                ->allOnQueue('exports-queue');
            return back()->withSuccess('Export started!');
        } else {
            return $this->download($request,$sensors);
        }

    }

    public function download(Request $request,$sensors)
    {
        $dates = $this->resolveDates($request->dates);
        //$sensors = $this->getSensors($request->sensors);
        //$sensor = $sensors->first();//deberia ser un foreach por cada sensor y guardarlo en hojas distintas

        $data =array();
        $sheetsName =array();

        foreach ($sensors as $sensor ){
            array_push($sheetsName,$sensor->name );
            array_push($data,$this->mapQuery($sensor,$dates));

        }
        $sheets = new SheetCollection(array_combine($sheetsName,$data));
        return (new FastExcel($sheets))->download('Data-'.Carbon::today()->toDateString().'.xlsx');
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
            $this->resolveQuery($sensor)
                ->with([
                    'sensor.device.check_point.sub_zones',
                    'sensor.type'
                ])
                ->where('sensor_id',$sensor->id),
            $dates
        );
    }

    protected function resolveQuery($sensor)
    {
        if($sensor->address->configuration_type == 'boolean') {
            $this->is_digital = true;
            return DigitalReport::query();
        } else {
            $this->is_digital = false;
            return  AnalogousReport::query();
        }
    }

    protected function mapQuery($sensor,$dates)
    {
        return $this->query($sensor,$dates)-> get()->sortBy('date')->map(function($item){
            return array_combine($this->getHeaders(),$this->resolveRow($item));
        });
    }

    protected function getHeaders(): array
    {
        if($this->is_digital) {
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

    public function resolveRow($row): array
    {
        if ($this->is_digital) {
            return  [
                $row->sensor->device->check_point->name,
                $row->sensor->name,
                (string)$row->value,
                $row->label,
                Carbon::parse($row->date)->toDateString(),
                Carbon::parse($row->date)->toTimeString(),
            ];
        } else {

            if ($row->sensor->type->id === 1 && strtolower($row->unit) === 'mt') {
                $interpreter = " UBba {$row->sensor->max_value} MT";
            } else {
                $interpreter = $row->interpreter;
            }

            return [
                $row->sensor->device->check_point->name,
                $row->sensor->name,
                $row->result,
                $row->unit,
                Carbon::parse($row->date)->toDateString(),
                Carbon::parse($row->date)->toTimeString(),
                $interpreter,
            ];
        }

    }

    protected function resolveDatesQuery($query,$dates)
    {
        return $query->whereRaw ("`date` between '{$dates['from']}' and '{$dates['to']}'");
    }
}
