<?php

namespace App\Domain\WaterManagement\Scale;

use App\Domain\WaterManagement\Device\Sensor\Disposition\SensorDisposition;
use Illuminate\Database\Eloquent\Model;

class Scale extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name' , 'min', 'max', 'precision'
    ];

    public function dispositions()
    {
        return $this->hasMany(SensorDisposition::class,'scale_id','id');
    }
}
