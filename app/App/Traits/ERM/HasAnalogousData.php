<?php

namespace App\App\Traits\ERM;

use App\Domain\Client\Zone\Sub\SubZone;
use App\Domain\WaterManagement\Device\Sensor\Sensor;

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

    protected function getData($sub_zone_id,$type)
    {
        return Sensor::with([
            'type',
            'dispositions.unit',
            'device.report',
        ])->whereIn('type_id',function($query) use($type){
            $query->select('id')->from('sensor_types')
                ->where('slug',$type);
        })->whereIn('id',function($query)  use($sub_zone_id){
            $query->select('sensor_id')
                    ->from('sub_element_sensors')
                ->leftJoin('sub_zone_sub_elements','sub_elements_sensors.sub_element_id','=','sub_zone_sub_elements.id')
                ->leftJoin('sub_zone_elements','sub_zone_elements.id','=','sub_zone_sub_elements.sub_zone_element_id')
                ->where('sub_zone_elements.sub_zone_id',$sub_zone_id);

        })->get();
       
    }
}
