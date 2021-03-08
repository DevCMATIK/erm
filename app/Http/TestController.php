<?php

namespace App\Http;

use App\App\Controllers\Soap\SoapController;
use App\App\Jobs\SendToDGA;
use App\App\Traits\ERM\HasAnalogousData;
use App\Domain\Client\CheckPoint\CheckPoint;
use App\Domain\Client\CheckPoint\DGA\CheckPointReport;
use App\Domain\Client\Zone\Zone;
use App\Domain\Data\Analogous\AnalogousReport;
use App\Domain\Data\Digital\DigitalReport;
use App\Domain\WaterManagement\Device\Sensor\Sensor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;
use Sentinel;


class TestController extends SoapController
{
    use HasAnalogousData;

    public $current_date = '2020-12-01';


    public function __invoke()
    {

       $name = 'Santa Rosa_Pozo Nº6 St. Rosa_Caudal';
       return $this->testResponse([
            'name' => $name,
            'compare' => ($name == $name)?'igual':'distinto',
            'slugged' => Str::slug($name),
            'compare-slugged' => (Str::slug($name) == Str::slug($name)) ? 'igual' : 'distinto'
       ]);
    }

    protected function getSensors()
    {

        return Sensor::with([
            'device.report',
            'address',
            'label',
            'type'
        ]) ->whereHas('type' , function($q){
            return $q->where('interval',77);
        })
            ->where('sensors.historial',1)
            ->whereHas('label')
            ->digital()
            ->where('id',406)
            ->get();
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
