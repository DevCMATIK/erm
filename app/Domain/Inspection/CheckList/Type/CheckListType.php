<?php

namespace App\Domain\Inspection\CheckList\Type;

use App\App\Traits\Model\Sluggable;
use Illuminate\Database\Eloquent\Model;

class CheckListType extends Model
{
    use Sluggable;

    public $timestamps = false;

    protected $fillable = [
        'slug','name'
    ];
}
