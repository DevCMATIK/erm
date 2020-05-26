<?php

namespace App\Domain\WaterManagement\Historical;

use App\Domain\Data\Analogous\AnalogousReport;
use App\Domain\Data\Digital\DigitalReport;
use Illuminate\Database\Eloquent\Model;

class HistoricalType extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'internal_id','name'
    ];

    public function analogous_reports()
    {
        return $this->hasMany(AnalogousReport::class,'historical_type_id','id');
    }


    public function digital_reports()
    {
        return $this->hasMany(DigitalReport::class,'historical_type_id','id');
    }
}
