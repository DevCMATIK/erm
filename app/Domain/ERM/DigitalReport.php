<?php

namespace App\Domain\ERM;

use Illuminate\Database\Eloquent\Model;

class DigitalReport extends Model
{
    protected $connection = 'erm';

    protected $table = 'watermanagement.digital_reports';


    protected $fillable = [
        'device_id',
        'register_type',
        'address',
        'sensor_id',
        'historical_type_id',
        'name',
        'on_label',
        'off_label',
        'value',
        'label',
        'date',
    ];

}
