<?php

namespace App\App\Traits\ERM;

use App\Domain\Client\Zone\Sub\SubZone;
use App\Domain\WaterManagement\Device\Sensor\Sensor;
use Illuminate\Support\Facades\DB;

trait HasAnalogousData
{
    protected function getAnalogousValue($sensor)
    {
        if($disposition = $this->getDisposition($sensor)) {
            if($report_value = $this->fixValues($sensor,$disposition,$this->getReportValue($sensor))) {
                $data = $this->lookForInterpreters($sensor,$this->getCalculatedData($disposition,$report_value));
                return [
                    'value' => $data,
                    'name' => $sensor->name,
                    'unit' => $disposition->unit->name,
                    'disposition' => $disposition,
                    'type' => $sensor->type->slug,
                    'color' => $this->getRange($sensor,$data)
                ];
            }
        }

        return false;
    }

    protected function getRange($sensor,$value)
    {
        if (count($sensor->ranges) > 0) {
            foreach($sensor->ranges as $range) {
                if((float)$value >= $range->min && (float)$value <= $range->max) {
                    return $range->color;
                }
            }
        }

        return 'success';
    }

    protected function lookForInterpreters($sensor,$value)
    {
        if(count($sensor->type->interpreters) > 0) {
            if($interpreter = $sensor->type->interpreters->where('value',(int) $value)->first()) {
                return $interpreter->name;
            }
        }

        return $value;
    }

    protected function getCalculatedData($disposition,$report_value)
    {
        $ing_min = $disposition->sensor_min;
        $ing_max = $disposition->sensor_max;
        $scale_min = $disposition->scale_min;
        $scale_max = $disposition->scale_max;
        if($scale_min == null && $scale_max == null) {
            return ($ing_min * $report_value) + $ing_max;
        } else {
            $f1 = $ing_max - $ing_min;
            $f2 = $scale_max - $scale_min;
            $f3 = $report_value - $scale_min;
            if($f2 == 0) {
                return (((0)*($f3)) + $ing_min);
            } else {
                return ((($f1/$f2)*($f3)) + $ing_min);
            }
        }
    }

    protected function fixValues($sensor,$disposition,$value)
    {
        if($sensor->fix_values_out_of_range === 1 && $value) {
            if($value < $disposition->scale_min) {
                return $disposition->scale_min;
            } else {
                if($value > $disposition->scale_max) {
                    return  $disposition->scale_max;
                }
            }
        }

        return $value;
    }

    protected function getReportValue($sensor)
    {
        $address = $sensor->full_address;

        if($sensor->device->from_bio === 1) {
            return DB::connection('bioseguridad')
                ->table('reports')
                ->where('grd_id',$sensor->device->internal_id)
                ->first()->{$address} ?? false;
        }

        return $sensor->device->report->{$address} ?? false;
    }

    protected function getDisposition($sensor)
    {
        return  $sensor->dispositions->where('id',$sensor->default_disposition)->first()
                ??
                $sensor->dispositions->first();
    }

    protected function getSensorById($sensor_id)
    {
        return Sensor::with([
            'type.interpreters',
            'dispositions.unit',
            'device.report',
            'ranges'
        ])->find($sensor_id);
    }

    protected function getSensorsBySubZoneAndType($sub_zone_id,$type)
    {
        return Sensor::with([
            'type.interpreters',
            'dispositions.unit',
            'device.report',
            'ranges'
        ])->whereIn('type_id',function($query) use($type){
            $query->select('id')->from('sensor_types')
                ->where('slug',$type);
        })->whereIn('id',function($query)  use($sub_zone_id){
            $query->select('sensor_id')
                    ->from('sub_element_sensors')
                ->leftJoin('sub_zone_sub_elements','sub_element_sensors.sub_element_id','=','sub_zone_sub_elements.id')
                ->leftJoin('sub_zone_elements','sub_zone_elements.id','=','sub_zone_sub_elements.sub_zone_element_id')
                ->where('sub_zone_elements.sub_zone_id',$sub_zone_id);
        })->get();
    }
}
