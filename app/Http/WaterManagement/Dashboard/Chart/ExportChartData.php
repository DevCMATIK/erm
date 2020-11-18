<?php

namespace App\Http\WaterManagement\Dashboard\Chart;

use App\Domain\Data\Analogous\AnalogousReport;
use App\Domain\Data\Export\ExportReminder;
use App\Domain\WaterManagement\Device\Sensor\Sensor;
use App\Exports\ExportChartDataWithSheets;
use App\Http\Data\Jobs\Export\CreateFileForSensor;
use App\Http\Data\Jobs\Export\ExportDataBySensor;
use App\Http\Data\Jobs\Export\SendMailExportCompleted;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;
use Sentinel;

class ExportChartData extends Controller
{
    public function __invoke(Request $request,$device_id,$sensor_id)
    {
        $s = array($sensor_id);
        if($request->has('sensors')) {
            $ss = array_merge($s,array_unique($request->sensors));
        } else {
            $ss = $s;
        }
        $sensors  = Sensor::with([
            'type',
            'device.check_point'
        ])->whereIn('id',$ss)->get();

        $dates = explode(' ',$request->dates);
        $from = date($dates[0]);
        $to = date($dates[2]);
        $from = Carbon::parse($from)->startOfDay();  //2016-09-29 00:00:00.000000
        $to = Carbon::parse($to)->endOfDay();

        if($to->diffInDays($from) > 60 || count($sensors) >= 15) {
            $reminder = ExportReminder::create([
                'user_id' => Sentinel::getUser()->id,
                'sensors' => $sensors->pluck('id')->implode(','),
                'from' => $from,
                'to' => $to,
                'creation_date' => Carbon::now()->toDateTimeString(),
                'expires_at' => Carbon::tomorrow()->toDateString()
            ]);
            $user_id = Sentinel::getUser()->id;
            $jobs = $sensors->map(function($item) use($from,$to,$user_id,$reminder){
                return new CreateFileForSensor($item,$from,$to,$user_id,$reminder);
            })->toArray();
            ExportDataBySensor::withChain(
                array_merge(
                    $jobs,
                    [ new SendMailExportCompleted(Sentinel::getUser(),$reminder)]
                )
            )->dispatch()
                ->allOnQueue('exports-queue');
            return response()->json(['success' => 'Export Started'],200);
        } else {
            $fileName = $sensors->first()->device->check_point->name.'.xlsx';
            if(strlen($fileName) > 31) {
                $fileName = substr($sensors->first()->device->check_point->name,'0','20').'.xlsx';
            }
            return $this->download($request);
        }

    }

    public function download(Request $request)
    {
        $dates = $this->resolveDates($request->dates);
        //$sensors = $this->getSensors($request->sensors);
        //$sensor = $sensors->first();//deberia ser un foreach por cada sensor y guardarlo en hojas distintas

        $data =array();
        $sheetsName =array();

        foreach ($this->getSensors($request->sensors) as $sensor ){
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
            AnalogousReport::query()
                ->with([
                    'sensor.device.check_point.sub_zones',
                    'sensor.type'
                ])
                ->where('sensor_id',$sensor->id),
            $dates
        )->orderBy('date');
    }

    protected function mapQuery($sensor,$dates)
    {
        return $this->query($sensor,$dates)-> get()->map(function($item){
            return array_combine($this->getHeaders(),$this->resolveRow($item));
        });
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
