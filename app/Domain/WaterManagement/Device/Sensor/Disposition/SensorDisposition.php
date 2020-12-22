<?php

namespace App\Domain\WaterManagement\Device\Sensor\Disposition;

use App\Domain\WaterManagement\Device\Sensor\Disposition\Line\DispositionLine;
use App\Domain\WaterManagement\Device\Sensor\Sensor;
use App\Domain\WaterManagement\Scale\Scale;
use App\Domain\WaterManagement\Unit\Unit;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class SensorDisposition extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    public $timestamps = false;

    protected $fillable = [
        'name','sensor_id','unit_id','scale_id','scale_min','scale_max','sensor_min','sensor_max','precision'
    ];

    public function sensor()
    {
        return $this->belongsTo(Sensor::class,'sensor_id','id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class,'unit_id','id');
    }

    public function scale()
    {
        return $this->belongsTo(Scale::class,'scale_id','id');
    }

    public function lines()
    {
        return $this->hasMany(DispositionLine::class,'sensor_disposition_id','id');
    }
}
