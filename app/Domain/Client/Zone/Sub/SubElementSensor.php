<?php

namespace App\Domain\Client\Zone\Sub;

use App\Domain\WaterManagement\Device\Sensor\Sensor;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class SubElementSensor extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    public $timestamps = false;

    protected $fillable = [
        'sub_element_id',
        'sensor_id',
        'position',
        'show_in_dashboard',
        'use_as_chart',
        'use_as_digital_chart',
        'is_not_an_output',
        'no_chart_needed',
        'means_up',
        'means_down'
    ];

    public function sub_element()
    {
        return $this->belongsTo(SubZoneSubElement::class,'sub_element_id','id');
    }

    public function sensor()
    {
        return $this->belongsTo(Sensor::class,'sensor_id','id')->enabled();
    }

    public function scopeDigital($query)
    {
        return $query->with('sensor')->whereHas('sensor', function($q) {
            return $q->digital();
        });
    }

    public function scopeAnalogous($query)
    {
        return $query->with('sensor')->whereHas('sensor', function($q) {
            return $q->analogous();
        });
    }

    public function sensor_digital()
    {
        return $this->sensor()->digital()->with([
            'address',
            'label',
            'device.report'
        ]);
    }

    public function sensor_analogous()
    {
        return $this->sensor()->analogous()->with([
            'sensor',
            'dispositions.unit',
            'device.report',
            'ranges'
        ]);
    }
}
