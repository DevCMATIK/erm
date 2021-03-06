<?php

namespace App\Domain\WaterManagement\Device\Sensor\Type;

use App\App\Traits\Model\Sluggable;
use App\Domain\WaterManagement\Device\Sensor\Sensor;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class SensorType extends Model implements Auditable
{
    use Sluggable, \OwenIt\Auditing\Auditable;

    public $timestamps = false;

    protected $fillable = [
        'slug','name','min_value','max_value','interval','is_exportable','is_dga','sensor_type'
    ];

    public function sensors()
    {
        return $this->hasMany(Sensor::class,'type_id','id');
    }

    public function interpreters()
    {
        return $this->hasMany(Interpreter::class,'type_id','id');
    }

    public function scopeType($query,$type)
    {
        return $query->where('slug',$type);
    }
}
