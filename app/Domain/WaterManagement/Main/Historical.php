<?php

namespace App\Domain\WaterManagement\Main;

use App\Domain\WaterManagement\Device\Device;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Historical extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

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
