<?php

namespace App\Domain\WaterManagement\Device\Sensor\Chronometer;

use App\App\Traits\Dates\HasDateScopes;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ChronometerTracking extends Model implements Auditable
{
    use HasDateScopes, \OwenIt\Auditing\Auditable;
    public $timestamps = false;

    protected $fillable = [
        'chronometer_id',
        'start_date',
        'end_date',
        'value'
    ];

    public function chronometer()
    {
      return $this->belongsTo(SensorChronometer::class,'chronometer_id','id');
    }
}
