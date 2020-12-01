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

    protected function getData($id)
    {
        return SubZone::with([
            'configuration',
            'elements.sub_elements.digital_sensors.sensor.label',
            'elements.sub_elements.digital_sensors.sensor.device.report',
            'elements.sub_elements.analogous_sensors.sensor',
            'elements.sub_elements.analogous_sensors.sensor.type.interpreters',
            'elements.sub_elements.analogous_sensors.sensor.dispositions.unit',
            'elements.sub_elements.analogous_sensors.sensor.ranges',
            'elements.sub_elements.analogous_sensors.sensor.device.report',
            'elements.sub_elements.active_alarm',
            'elements.sub_elements.active_and_not_accused_alarm',
            'elements.sub_elements.check_point'
        ])->has('configuration')->findOrFail($id);
    }
}
