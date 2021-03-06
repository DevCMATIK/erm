<?php

namespace App\Http\WaterManagement\Dashboard\Kpi;

use App\App\Traits\ERM\HasAnalogousData;
use App\Domain\Client\Zone\Zone;
use App\Domain\Data\Analogous\AnalogousReport;
use App\Domain\WaterManagement\Device\Sensor\Sensor;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;
use Illuminate\Support\Arr;
use Sentinel;

class CupLevelsController extends Controller
{
    use HasAnalogousData;

    public function __invoke()
    {
        return view('water-management.dashboard.statistics.cup-levels',[
            'zones' => $this->getSensors()
                ->groupBy('zone')
                ->sortByDesc(function($zone){
                    return count($zone);
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
            'type.interpreters',
            'dispositions.unit',
            'device.report',
            'device.check_point.sub_zones.zone',
            'device.check_point.type',
            'device.check_point.label',
            'ranges'
        ])
            ->where('type_id',32)
            ->where('address_id',1)
            ->whereIn('device_id', function($query) {
                $query->select('id')->from('devices')->whereIn('check_point_id',function($query) {
                    $query->select('id')->from('check_points')->wherein('type_id',function($query){
                        $query->select('id')->from('check_point_types')->whereIn('slug',['copas','relevadoras']);
                    });
                });
            })
            ->whereIn('device_id',$this->getDevicesId())
            ->get()->map(function($sensor){
                return [
                    'zone' => $sensor->device->check_point->sub_zones->first()->zone->name,
                    'check_point' =>  $sensor->device->check_point->label->first()->label ?? $sensor->device->check_point->name,
                    'sub_zone_id' => $sensor->device->check_point->sub_zones->first()->id,
                    'data' => $this->getAnalogousValue($sensor)
                ];
            });
    }
}
