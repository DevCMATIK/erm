<?php

namespace App\Http\WaterManagement\Admin\Device\Controllers;

use App\Domain\Client\Zone\Zone;
use App\Domain\WaterManagement\Device\Device;
use App\Http\System\DataTable\DataTableAbstract;
use Carbon\Carbon;
use Sentinel;

class OfflineDevicesDatatableController extends DataTableAbstract
{
    public $entity = 'offline-devices';

    public function getRecords()
    {
        return  Device::with('report','check_point.sub_zones.zone','last_disconnection')->whereIn('id',$this->getDevicesId())->withCount('disconnections')->get()->filter(function($device){
            return optional($device->report)->state === 0;
        });
    }

    public function getRecord($record)
    {
            return [
                $record->check_point->sub_zones()->first()->zone->name,
                $record->check_point->sub_zones()->first()->name,
                $record->check_point->name,
                $record->name,
                $record->internal_id,
                $record->disconnections_count,
                optional($record->last_disconnection()->first())->start_date,
                Carbon::now()->longAbsoluteDiffForHumans(Carbon::parse($record->last_disconnection()->first()->start_date)),
                makeRemoteLink('/device-disconnections/'.$record->id,'Log','fa-database','btn-link','btn-sm')
            ];
    }

    protected function getDevicesId()
    {
        $ids = array();
        $zones = Zone::whereHas('sub_zones', $filter =  function($query){
            $query->whereIn('id',Sentinel::getUser()->getSubZonesIds())->whereHas('configuration');
        })->with( ['sub_zones' => $filter,'sub_zones.sub_elements'])->get();
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
}
