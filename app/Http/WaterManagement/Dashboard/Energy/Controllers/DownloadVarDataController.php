<?php

namespace App\Http\WaterManagement\Dashboard\Energy\Controllers;

use App\App\Traits\ERM\HasAnalogousData;
use App\Domain\Data\Analogous\AnalogousReport;
use App\Domain\Data\Export\ExportReminder;
use App\Http\Data\Jobs\Export\CreateFileForSensor;
use App\Http\Data\Jobs\Export\ExportDataBySensor;
use App\Http\Data\Jobs\Export\SendMailExportCompleted;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;

use Sentinel;

use Rap2hpoutre\FastExcel\FastExcel;
use Rap2hpoutre\FastExcel\SheetCollection;

class DownloadVarDataController extends Controller
{
    use HasAnalogousData;

    public function __invoke(Request $request,$sub_zone_id)
    {
        if(isset($request->sensor_name) && $request->sensor_name != null ){
            $sensors = $this->getSensorsBySubZoneAndType($sub_zone_id,$request->name);

        } else {
            dd('here');
            $sensors = $this->getSensorsBySubZoneAndName($sub_zone_id,$request->name,$request->sensor_name);

        }

        $from = Carbon::parse($request->start_date)->startOfDay();  //2016-09-29 00:00:00.000000
        $to = Carbon::parse($request->end_date)->endOfDay();
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
            return back()->withSuccess('Export started!');
        } else {
            return $this->download($request,$sensors);
        }

    }

    public function download(Request $request,$sensors)
    {


        $data =array();
        $sheetsName =array();

        foreach ($sensors as $sensor ){
            array_push($sheetsName,$sensor->name );
            array_push($data,$this->mapQuery($sensor,$request->start_date,$request->end_date));

        }
        $sheets = new SheetCollection(array_combine($sheetsName,$data));
        return (new FastExcel($sheets))->download('Data-'.Carbon::today()->toDateString().'.xlsx');
    }

    protected function query($sensor,$start_date,$end_date)
    {
        return $this->resolveDatesQuery(
            AnalogousReport::query()
                ->with([
                    'sensor.device.check_point.sub_zones',
                    'sensor.type'
                ])
                ->where('sensor_id',$sensor->id),
            $start_date,
            $end_date
        )->orderBy('date');
    }

    protected function mapQuery($sensor,$start_date,$end_date)
    {
        return $this->query($sensor,$start_date,$end_date)-> get()->map(function($item){
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
            (float) $result,
            $row->unit,
            Carbon::parse($row->date)->toDateString(),
            Carbon::parse($row->date)->format('H:i'),
            $interpreter,

        ];
    }

    protected function resolveDatesQuery($query,$start_date,$end_date)
    {
        return $query->whereRaw ("`date` between '{$start_date}' and '{$end_date}'");
    }
}
