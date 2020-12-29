<?php

namespace App\Domain\Client\CheckPoint\Totalizer;

use App\App\Traits\Dates\HasDateScopes;
use App\Domain\Client\CheckPoint\CheckPoint;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class CheckPointTotalizer extends Model implements Auditable
{
    use HasDateScopes, \OwenIt\Auditing\Auditable;

    public $timestamps = false;

    protected $fillable = [
        'check_point_id',
        'first_read',
        'last_read',
        'totalizer_fix',
        'input',
        'date',
    ];

    public function check_point()
    {
        return $this->belongsTo(CheckPoint::class,'check_point_id','id');
    }
}
