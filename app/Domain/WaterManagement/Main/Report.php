<?php

namespace App\Domain\WaterManagement\Main;

use App\Domain\WaterManagement\Device\Device;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $connection= 'grdxf';

    protected $table = 'grdxf.reports';

    public function scopeOffline($query)
    {
        return $query->where('state',0);
    }

    public function scopeOnline($query)
    {
        return $query->where('state',1);
    }

}
