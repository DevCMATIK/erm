<?php

namespace App\Domain\ERM;

use Illuminate\Database\Eloquent\Model;

class AnalogousReport extends Model
{

    protected $connection= 'erm';

    protected $table = 'watermanagement.analogous_reports';


    protected $fillable = [
        'device_id',
        'register_type',
        'address',
        'sensor_id',
        'historical_type_id',
        'scale',
        'scale_min',
        'scale_max',
        'ing_min',
        'ing_max',
        'unit',
        'value',
        'result',
        'date',
        'scale_color',
        'interpreter'
    ];
}
