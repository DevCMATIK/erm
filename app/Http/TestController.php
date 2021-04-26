<?php

namespace App\Http;

use App\App\Controllers\Soap\SoapController;
use App\App\Jobs\DGA\RestoreReports;
use App\App\Jobs\DGA\RestoreToDGA;
use App\App\Traits\ERM\HasAnalogousData;
use App\Domain\Client\CheckPoint\CheckPoint;
use App\Domain\Client\CheckPoint\DGA\CheckPointReport;
use App\Domain\Client\Zone\Sub\MapLine;
use App\Domain\Client\Zone\Sub\SubZone;
use App\Domain\Data\Analogous\AnalogousReport;
use App\Domain\WaterManagement\Device\Sensor\Sensor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;


class TestController extends SoapController
{
    use HasAnalogousData;

    public $current_date = '2020-12-01';


    public function __invoke(Request $request)
    {
        $lines = MapLine::with(['p_one','p_two'])->orderBy('position')->get()->map(function($item) {
            $pOneLng = '';
            $pOneLat = '';
            $pTwoLng = '';
            $pTwoLat = '';
            if($item->one_lng !== null) {
                $pOneLng = $item->one_lng;
            } else {
                $pOneLng = $item->p_one->lng;
            }

            if($item->one_lat !== null) {
                $pOneLat = $item->one_lat;
            } else {
                $pOneLat = $item->p_one->lat;
            }

            if($item->two_lng !== null) {
                $pTwoLng = $item->two_lng;
            } else {
                $pTwoLng = $item->p_two->lng;
            }

            if($item->two_lat !== null) {
                $pTwoLat = $item->two_lat;
            } else {
                $pTwoLat = $item->p_two->lat;
            }
            return [
                'p_one_lng' => $pOneLng,
                'p_one_lat' => $pOneLat,
                'p_two_lng' => $pTwoLng,
                'p_two_lat' => $pTwoLat,
                'color' => $item->color
            ];
        });

        return view('test.map',[
            'sub_zones' => SubZone::where('zone_id',11)->get(),
            'lines' => $lines
        ]);
    }

    protected function getSensors($checkPoint)
    {
        return $this->getSensorsByCheckPoint($checkPoint)
            ->whereIn('type_id',function($query){
                $query->select('id')->from('sensor_types')
                    ->where('is_dga',1)
                    ->whereIn('sensor_type',[
                        'tote',
                        'level',
                        'flow',
                    ]);
            })->get();
    }

    protected function getSensorsByCheckPoint($check_point)
    {

        return Sensor::query()->with([
            'device.check_point',
        ]) ->whereIn('address_id', function($query){
            $query->select('id')
                ->from('addresses')
                ->where('configuration_type','scale');
        })->whereIn('device_id',function($query)  use($check_point){
            $query->select('id')
                ->from('devices')
                ->where('check_point_id',$check_point);
        });;
    }

    protected function getLevelSensor($sensors)
    {
        return $sensors->filter(function($sensor) {
            return collect(['level'])->contains($sensor->type->sensor_type);
        })->first();
    }

    protected function getToteSensor($sensors)
    {
        return $sensors->filter(function($sensor) {
            return collect(['tote'
            ])->contains($sensor->type->sensor_type);
        })->first();

    }

    protected function getFlowSensor($sensors)
    {
        return $sensors->filter(function($sensor) {
            return collect(['flow'
            ])->contains($sensor->type->sensor_type);
        })->first();

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
