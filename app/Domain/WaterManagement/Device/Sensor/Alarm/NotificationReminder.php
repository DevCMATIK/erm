<?php

namespace App\Domain\WaterManagement\Device\Sensor\Alarm;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class NotificationReminder extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    public $timestamps =  false;
}
