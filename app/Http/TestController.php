<?php

namespace App\Http;

use App\App\Controllers\Soap\SoapController;
use App\App\Jobs\DGA\GetChekpointsToRestore;
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
        $toInsert = array();
        $first_date = Carbon::yesterday()->toDateString();
        $second_date = Carbon::today()->toDateString();
        $sensors =  Sensor::whereHas('type', $typeFilter = function ($q) {
            return $q->where('slug',$this->sensor_type);
        })->whereHas('analogous_reports', $reportsFilter = function($query) use ($first_date,$second_date){
            return $query->whereRaw("date between '{$first_date} 00:00:00' and '{$second_date} 00:01:00'");
        })->with([
            'type' => $typeFilter,
            'device.check_point.sub_zones',
            'analogous_reports' => $reportsFilter,
            'consumptions'
        ])->get();

        foreach($sensors as $sensor) {
            if(count($sensor->consumptions) > 0) {
                $first_read = $sensor->consumptions->sortByDesc('date')->first()->last_read;
                $last_read = $sensor->analogous_reports->sortByDesc('date')->first()->result;
            } else {
                $first_read = $sensor->analogous_reports->sortBy('date')->first()->result;
                $last_read = $sensor->analogous_reports->sortByDesc('date')->first()->result;
            }
            $consumption_yesterday = $sensor->consumptions->where('date',Carbon::yesterday()->toDateString())->first();

                if($first_read && $last_read) {
                    $consumption = $last_read - $first_read;

                    array_push($toInsert,[
                        'sensor_id' => $sensor->id,
                        'first_read' => $first_read,
                        'last_read' => $last_read,
                        'consumption' => $consumption,
                        'sensor_type' => $sensor->type->slug,
                        'sub_zone_id' => $sensor->device->check_point->sub_zones->first()->id,
                        'date' => Carbon::yesterday()->toDateString()
                    ]);
                }

        }

        return $this->testResponse([$toInsert]);
    }

    protected function getLines($subZones)
    {
        $subZones = collect($subZones);
        return MapLine::with(['p_one','p_two'])->orderBy('position')->get()->map(function($item) use ($subZones) {
            $l = array();

            array_push($l,[
                'lng' => $item->p_one->lng,
                'lat' => $item->p_one->lat
            ]);

            if($item->points_between != null) {
                foreach(json_decode($item->points_between) as $point) {
                    $coords = explode(',',str_replace(' ','',$point));
                    array_push($l,[
                        'lng' => $coords[1],
                        'lat' => $coords[0]
                    ]);
                }
            }

            array_push($l,[
                'lng' => $item->p_two->lng,
                'lat' => $item->p_two->lat
            ]);

            if($subZones->where('id',$item->point_one)->first()['status']['state'] == 1){
                $color = $item->color;
            } else {
                $color = '#B2BABB';
            }
            return [
                'lines' => $l,
                'color' => $color
            ];
        });
    }

    protected function getSubZones($id)
    {
       return  SubZone::with('check_points.devices.report')
            ->where('zone_id',$id)
            ->get()
            ->map(function($subZone){
                return [
                    'id' => $subZone->id,
                    'name' => $subZone->name,
                    'lat' => $subZone->lat,
                    'lng' => $subZone->lng,
                    'status' => $subZone->check_points->map(function($checkPoint){
                        $okCount = 0;
                        $offCount = 0;
                        foreach($checkPoint->devices->map(function($device){
                            return $device->report->state;
                        }) as $state){
                            if($state == 0) {
                                $offCount++;
                            } else {
                                $okCount++;
                            }
                        }

                        if($offCount > 0 && $okCount <= 0) {
                            return ['state' => 0, 'color' => '#F74C41' ]; //rojo
                        } elseif ($offCount > 0 && $okCount > 0) {
                            return ['state' => 0, 'color' => '#ACACAC' ]; //plomo
                        } else {
                            return ['state' => 1, 'color' => '#6AD252' ]; //verde
                        }
                    })->toArray()[0]
                ];
            });
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
