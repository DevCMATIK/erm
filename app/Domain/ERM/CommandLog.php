<?php

namespace App\Domain\ERM;

use Illuminate\Database\Eloquent\Model;

class CommandLog extends Model
{
    protected $connection = 'erm';

    protected $table = 'watermanagement.command_logs';

    protected $fillable = [
        'user_id',
        'device_id',
        'sensor_id',
        'grd_id',
        'address',
        'order_executed',
        'execution_date',
        'ip_address'
    ];

}
