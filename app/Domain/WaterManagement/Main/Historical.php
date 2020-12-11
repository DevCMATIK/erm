<?php

namespace App\Domain\WaterManagement\Main;

use App\Domain\WaterManagement\Device\Device;
use Illuminate\Database\Eloquent\Model;

class Historical extends Model
{

    protected $connection= 'grdxf';

    protected $table = 'historical';

    protected $primaryKey = 'historial_id';

    public $incrementing = false;





    public $timestamp = false;

    public function device()
    {
        return $this->hasMany(Device::class,'internal_id','grd_id');
    }
}
