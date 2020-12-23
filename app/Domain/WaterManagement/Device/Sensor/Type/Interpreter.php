<?php

namespace App\Domain\WaterManagement\Device\Sensor\Type;

use Illuminate\Database\Eloquent\Model;

class Interpreter extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'value',
        'name',
        'description',
        'type_id'
    ];

    public function type()
    {
        return $this->belongsTo(SensorType::class,'type_id','id');
    }
}
