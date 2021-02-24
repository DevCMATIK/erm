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
        $zones = $this->getZones();

        return $this->testResponse([
            'zones' => $zones,
            'sensors' => $this->getSensors($zones)
        ]);
    }

    protected function getZones()
    {
        return Zone::with([
            'sub_zones.configuration',
            'sub_zones.sub_elements'
        ])->get()->filter(function($item){
            return $item->sub_zones->filter(function($sub_zone) {
                    return Sentinel::getUser()->inSubZone($sub_zone->id) && isset($sub_zone->configuration);
                })->count() > 0;
        });
    }

    protected function getDevicesId($zones)
    {
        $ids = array();
        foreach($zones as $zone) {
            foreach($zone->sub_zones as $sub_zone) {
                foreach($sub_zone->sub_elements as $sub_element) {
                    if(Sentinel::getUser()->inSubZone($sub_zone->id)) {
                        array_push($ids,$sub_element->device_id);
                    }
                }
            }
        }

        return $ids;
    }

    protected function getSensors($zones)
    {
        return Sensor::leftJoin('devices','devices.id','=','sensors.device_id')
            ->leftJoin('check_points','check_points.id','=','devices.check_point_id')
            ->leftJoin('check_point_labels','devices.id','=','check_point_labels.device_id')
            ->leftJoin('check_point_types','check_point_types.id','=','check_points.type_id')
            ->leftJoin('addresses','addresses.id','=','sensors.address_id')
            ->where('sensors.type_id',32 )
            ->whereNull('devices.deleted_at')
            ->whereNull('check_points.deleted_at')
            ->whereRaw("(check_point_types.slug = 'copas' or check_point_types.slug = 'relevadoras') and addresses.register_type_id = 11")
            ->whereIn('devices.id',$this->getDevicesId($zones))
            ->selectRaw('check_points.name as check_point,check_points.id as check_point_id,check_point_labels.label as label,sensors.address_number as address,addresses.register_type_id,devices.id as device_id')
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
