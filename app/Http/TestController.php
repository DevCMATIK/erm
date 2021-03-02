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
use Sentinel;


class TestController extends SoapController
{
    use HasAnalogousData;

    public $current_date = '2020-12-01';


    public function __invoke()
    {
        $sensors = $this->getSensors();

        $toInsert = array();
        $reports_values = array();

        foreach($sensors as $sensor) {

            $address = $sensor->full_address;
            $report_value = $this->getReportValue($sensor);
            array_push($reports_values,[
                'report_value' => $report_value,
                'sensor' => $sensor->id
            ]);
            if($report_value !== false) {
                dd('report_value ok');
                if($sensor->type->interval == 77) {
                    dd('valor_distinto');
                    if($sensor->last_value != $report_value) {
                        dd('valor_distinto');
                        array_push($toInsert, [
                            'device_id' => $sensor->device->id,
                            'register_type' => $sensor->address->register_type_id,
                            'address' => $sensor->address_number,
                            'sensor_id' => $sensor->id,
                            'name' => $sensor->name,
                            'on_label' => $sensor->label->on_label,
                            'off_label' => $sensor->label->off_label,
                            'value' => $report_value,
                            'label' => ($report_value === 1)? $sensor->label->on_label : $sensor->label->off_label,
                            'date' => Carbon::now()->toDateTimeString()
                        ]);
                        $sensor->last_value = $report_value;
                        $sensor->save();
                    }
                } else {
                    dd('aca no deberia');
                    array_push($toInsert, [
                        'device_id' => $sensor->device->id,
                        'register_type' => $sensor->address->register_type_id,
                        'address' => $sensor->address_number,
                        'sensor_id' => $sensor->id,
                        'name' => $sensor->name,
                        'on_label' => $sensor->label->on_label,
                        'off_label' => $sensor->label->off_label,
                        'value' => $report_value,
                        'label' => ($report_value === 1)? $sensor->label->on_label : $sensor->label->off_label,
                        'date' => Carbon::now()->toDateTimeString()
                    ]);
                }
            }



        }

        return $this->testResponse([
            'to_insert' => $toInsert,
            'report_value' => $reports_values
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
