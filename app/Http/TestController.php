<?php

namespace App\Http;

use App\App\Controllers\Soap\SoapController;
use App\App\Jobs\SendToDGA;
use App\App\Traits\ERM\HasAnalogousData;
use App\Domain\Client\CheckPoint\CheckPoint;
use App\Domain\Client\CheckPoint\DGA\CheckPointReport;
use App\Domain\Client\Zone\Zone;
use App\Domain\Data\Analogous\AnalogousReport;
use App\Domain\ERM\AnalogousReports;
use App\Domain\WaterManagement\Device\Sensor\Sensor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Sentinel;


class TestController extends SoapController
{
    use HasAnalogousData;

    public $current_date = '2020-12-01';


    public function __invoke(Request $request)
    {
       $last_id = AnalogousReport::orderBy('date','desc')->first();

       $analogous_reports = AnalogousReports::where('id','>',$last_id->id)->chunk(1000, function($reports) {
           $report_array = array();

           foreach($reports as $report) {
               array_push($report_array,[
                   'device_id' => $report->device_id,
                   'register_type' => $report->register_type,
                   'address' => $report->address,
                   'sensor_id' => $report->sensor_id,
                   'historical_type_id' => $report->historical_type_id,
                   'scale' => $report->scale,
                   'scale_min' => $report->scale_min,
                   'scale_max' => $report->scale_max,
                   'ing_min' => $report->ing_min,
                   'ing_max' => $report->ing_max,
                   'unit' => $report->unit,
                   'value' => $report->value,
                   'result' => $report->result,
                   'date' => $report->date,
                   'scale_color' => $report->scale_color,
                   'interpreter' => $report->interpreter
               ]);
           }

           AnalogousReport::insert($report_array);
       });


       return $this->testResponse([count($analogous_reports)]);
    }


    public function testResponse($results)
    {
        return response()->json(array_merge(['results' => $results],$this->getExecutionTime()));
    }

    public function getExecutionTime()
    {
        return [
            'time_in_seconds' => (microtime(true) - LARAVEL_START)
        ];
    }
}
