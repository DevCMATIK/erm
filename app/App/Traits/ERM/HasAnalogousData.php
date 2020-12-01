<?php

namespace App\App\Traits\ERM;

use App\Domain\Client\Zone\Sub\SubZone;

trait HasAnalogousData
{
    protected function calculateAnalogousValue($sensor)
    {

    }

    protected function getSensors($sensors)
    {

    }

    protected function getSensorsByNameAndSubZone($sub_zone,$name)
    {
        return $sub_zone->elements->map(function($element){
            return $element->sub_elements->map(function($sub_element){
                return $sub_element->analogous_sensors->map(function($item){
                    return $item;
                });
            });
        })->collapse()->collapse()->groupBy('sensor.type.slug')->map(function($item,$key){
            return $item->groupBy('sensor.name');
        });
    }

    protected function getData($id,$type)
    {
        return SubZone::with([
            'configuration',
            'elements.sub_elements.analogous_sensors.sensor.type',
            'elements.sub_elements.analogous_sensors.sensor.dispositions.unit',
            'elements.sub_elements.analogous_sensors.sensor.device.report',
        ])->leftJoin('sub_zone_elements','sub_zone_elements.sub_zone_id','=','sub_zones.id')
            ->leftJoin('sub_zone_sub_elements','sub_zone_sub_elements.sub_zone_element_id','=','sub_zone_elements.id')
            ->leftJoin('sub_element_sensors','sub_element_sensors.sub_element_id','=','sub_zone_sub_elements.id')
            ->leftJoin('sensors','sub_element_sensors.sensor_id','=','sensors.id')
            ->join('sensor_types','sensors.type_id','=','sensor_types.id')
            ->where('sensor_types.slug',$type)
            ->has('configuration')->findOrFail($id);
    }
}
