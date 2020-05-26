<?php

namespace App\Domain\Client\CheckPoint\Grid;

use App\Domain\Client\CheckPoint\CheckPoint;
use App\Domain\WaterManagement\Device\Sensor\Sensor;
use Illuminate\Database\Eloquent\Model;

class CheckPointGrid extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'check_point_id',
        'sensor_id',
        'column',
        'row'
    ];

    public function check_point()
    {
        return $this->belongsTo(CheckPoint::class,'check_point_id','id');
    }

    public function sensor()
    {
        return $this->belongsTo(Sensor::class,'sensor_id','id');
    }
}
