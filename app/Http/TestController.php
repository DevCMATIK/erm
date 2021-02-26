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

       $analogous_reports = AnalogousReports::where('id','>',$last_id->id)->get();

       $reports = array();

       foreach($analogous_reports->chunk(1000) as $chunk)
       {
           AnalogousReport::insert($chunk->toArray());
       }

       return $this->testResponse([count($analogous_reports)]);
    }

    protected function transformData($rows){
        $array = array();
        if (stristr($rows->first()->sensor->name,'Aporte')  ) {
            foreach ($rows as $key => $row) {
                if($row->result >0) {
                    array_push($array, [
                        'x' => (strtotime($row->date))*1000,
                        'y' => (integer)number_format($row->result,0,'',''),
                        'name' => $row->date
                    ]);
                }

            }

        }else {
            foreach ($rows as $key => $row) {
                array_push($array, [
                    'x' => (strtotime($row->date))*1000,
                    'y' => (float)number_format($row->result,2,'.',''),
                    'name' => $row->date
                ]);
            }
        }


        return $array;
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
