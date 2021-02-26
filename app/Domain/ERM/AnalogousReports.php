<?php

namespace App\Domain\ERM;

use Illuminate\Database\Eloquent\Model;

class AnalogousReports extends Model
{
    protected $connection= 'erm';

    protected $table = 'watermanagement.analogous_reports';
}
