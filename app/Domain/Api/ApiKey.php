<?php

namespace App\Domain\Api;

use App\Domain\WaterManagement\Device\Sensor\Sensor;
use Illuminate\Database\Eloquent\Model;

class ApiKey extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'api_key',
        'is_valid',
        'last_access'
    ];

    public function sensors()
    {
        return $this->hasMany(ApiSensors::class,'api_key_id','id');
    }
}
