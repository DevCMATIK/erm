<?php

namespace App\Domain\Api;

use App\Domain\WaterManagement\Device\Sensor\Sensor;
use Illuminate\Database\Eloquent\Model;

class ApiSensors extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'api_key_id',
        'sensor_id'
    ];

    public function api_key()
    {
        return $this->belongsTo(ApiKey::class);
    }

    public function sensor()
    {
        return $this->belongsTo(Sensor::class);
    }
}
