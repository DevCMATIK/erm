<?php

namespace App\Domain\Data\Analogous;

use Illuminate\Database\Eloquent\Model;

class AnalogousDispositionsReport extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'analogous_report_id',
        'scale',
        'scale_min',
        'scale_max',
        'ing_min',
        'ing_max',
        'unit',
        'value',
        'result',
    ];

    public function analogous_report()
    {
        return $this->belongsTo(AnalogousReport::class,'analogous_report_id','id');
    }
}
