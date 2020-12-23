<?php

namespace App\Domain\WaterManagement\Main;

use App\Domain\WaterManagement\Device\Device;
use Illuminate\Database\Eloquent\Model;

class Command extends Model
{
    public $timestamps = false;

    protected $connection= 'grdxf';

    protected $table = 'commands';

    protected $fillable = [
        'command_id',
        'function',
        'grd_id', // dispositivo
        'register_type', // tipo registro
        'output_number', // address
        'state', //
        'date'
    ];

    public function device()
    {
        return $this->hasMany(Device::class,'internal_id','grd_id');
    }
}
