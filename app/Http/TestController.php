<?php

namespace App\Http;

use App\App\Controllers\Soap\SoapController;
use App\App\Jobs\SendToDGA;
use App\App\Traits\ERM\HasAnalogousData;
use App\Domain\Client\CheckPoint\CheckPoint;
use App\Domain\Client\CheckPoint\DGA\CheckPointReport;
use App\Domain\Client\Zone\Zone;
use App\Domain\WaterManagement\Device\Sensor\Sensor;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Sentinel;


class TestController extends SoapController
{
    use HasAnalogousData;

    public $current_date = '2020-12-01';

    public function __invoke()
    {

        return $this->testResponse([
            'sensors' => $this->getSensors()->map(function($sensor){
                return [
                    'zone' => $sensor->device->check_point->sub_zones->first()->zone->name,
                    'sub_zone' => $sensor->device->check_point->sub_zones->first()->name,
                    'check_point' => $sensor->device->checkpoint->name,
                    'value' => $this->getAnalogousValue($sensor,true)
                ];
            })
        ]);
    }

    protected function getZones()
    {
        $user_sub_zones = Sentinel::getUser()->sub_zones()->pluck('id')->toArray();

        return Zone::with([
            'sub_zones.configuration',
            'sub_zones.sub_elements'
        ])->get()->filter(function($item) use($user_sub_zones){
            return $item->sub_zones->filter(function($sub_zone)  use ($user_sub_zones){
                    return in_array($sub_zone->id,$user_sub_zones) && isset($sub_zone->configuration);
                })->count() > 0;
        });
    }

    protected function getDevicesId()
    {
        $ids = array();

        foreach($this->getZones() as $zone) {
            foreach($zone->sub_zones as $sub_zone) {
                foreach($sub_zone->sub_elements as $sub_element) {
                    array_push($ids,$sub_element->device_id);
                }
            }
        }

        return $ids;
    }

    protected function getSensors()
    {
        return Sensor::query()->with([
            'address',
            'type.interpreters',
            'dispositions.unit',
            'device.report',
            'device.check_point.sub_zones.zone',
            'ranges'
        ])
            ->where('type_id',32)
            ->whereIn('device_id', function($query) {
                $query->select('id')->from('devices')->whereIn('check_point_id',function($query) {
                   $query->select('id')->from('check_points')->wherein('slug',['copas','relevadoras']);
                });
            })->whereIn('address_id',function($query){
                $query->select('id')->from('addresses')->where('register_type_id',11);
            })
            ->whereIn('device_id',$this->getDevicesId())
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
