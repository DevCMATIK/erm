<?php

namespace App\Domain\WaterManagement\Scale;

use App\Domain\WaterManagement\Device\Sensor\Disposition\SensorDisposition;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Scale extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    public $timestamps = false;

    protected $fillable = [
        'name' , 'min', 'max', 'precision'
    ];

    public function dispositions()
    {
        return $this->hasMany(SensorDisposition::class,'scale_id','id');
    }
}
