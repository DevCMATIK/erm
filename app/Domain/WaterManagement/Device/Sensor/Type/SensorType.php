<?php

namespace App\Domain\WaterManagement\Device\Sensor\Type;

use App\App\Traits\Model\Sluggable;
use App\Domain\WaterManagement\Device\Sensor\Sensor;
use Illuminate\Database\Eloquent\Model;

class SensorType extends Model
{
    use Sluggable;

    public $timestamps = false;

    protected $fillable = [
        'slug','name','min_value','max_value','interval'
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
