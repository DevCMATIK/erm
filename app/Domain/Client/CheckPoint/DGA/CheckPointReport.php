<?php

namespace App\Domain\Client\CheckPoint\DGA;

use App\Domain\Client\CheckPoint\CheckPoint;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class CheckPointReport extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

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
