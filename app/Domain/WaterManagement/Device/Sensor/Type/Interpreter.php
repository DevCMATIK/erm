<?php

namespace App\Domain\WaterManagement\Device\Sensor\Type;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Interpreter extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
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
