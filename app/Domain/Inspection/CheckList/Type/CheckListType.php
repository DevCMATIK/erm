<?php

namespace App\Domain\Inspection\CheckList\Type;

use App\App\Traits\Model\Sluggable;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class CheckListType extends Model implements Auditable
{
    use Sluggable, \OwenIt\Auditing\Auditable;

    public $timestamps = false;

    protected $fillable = [
        'slug','name'
    ];
}
