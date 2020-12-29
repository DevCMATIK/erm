<?php

namespace App\Domain\WaterManagement\Report;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class MailReportSensor extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    //
}
