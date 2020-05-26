<?php

namespace App\Http;

use App\App\Controllers\Soap\SoapController;
use App\Domain\Client\Area\Area;
use App\Domain\WaterManagement\Device\Sensor\Sensor;
use Illuminate\Http\Request;
use Sentinel;

class TestController extends SoapController
{


    public function __invoke(Request $request)
    {
        $time_start = microtime(true);

        $areas = Area::with('zones.sub_zones.configuration')->get()->filter(function($item){
            return $item->zones->filter(function($zone) {
                    return $zone->sub_zones->filter(function($sub_zone) {
                        return (Sentinel::getUser()->inSubZone($sub_zone->id) && isset($sub_zone->configuration));
                        })->count() > 0;
                })->count() > 0;
        })->toArray();
        $zones = Area::has('zones.sub_zones.configuration')->whereHas('zones.sub_zones', $filter =  function($query){
           $query->whereIn('id',Sentinel::getUser()->getSubZonesIds());
        })->with( ['zones.sub_zones' => $filter])->get();
        $time_end = microtime(true);

        $execution_time = ($time_end - $time_start);
        dd($execution_time,$areas,$zones);
    }


    protected function getSensors()
    {
        $sensors = Sensor::with('type','device.check_point.type')->whereHas('type', function($query){
            $query->where('slug','tx-caudal')
                ->orWhere('slug','ee-tension-l-n')
                ->orWhere('slug','ee-corriente')
                ->orWhere('slug','ee-p-activa')
                ->orWhere('slug','ee-p-aparente')
                ->orWhere('slug','ee-p-act-u')
                ->orWhere('slug','partidor-danfoss')
                ->orWhere('slug','ee-tension-l-l')
                ->orWhere('slug','modbus');
        })->get();
    }
}
