<?php

namespace App\Domain\Client\CheckPoint\DGA;

use App\Domain\Client\CheckPoint\CheckPoint;
use Illuminate\Database\Eloquent\Model;

class CheckPointReport extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'check_point_id',
        'response',
        'response_text',
        'tote_reported',
        'flow_reported',
        'water_table_reported',
        'report_date'
    ];

    public function check_point()
    {
        return $this->belongsTo(CheckPoint::class, 'check_point_id', 'id');
    }

}
