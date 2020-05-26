<?php

namespace App\Domain\WaterManagement\Unit;

use App\Domain\WaterManagement\Device\Sensor\Disposition\SensorDisposition;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    public $timestamps = false;

    protected $fillable = ['name'];

    public function dispositions()
    {
        return $this->hasMany(SensorDisposition::class,'unit_id','id');
    }


}
