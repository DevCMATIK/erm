<?php

namespace App\Domain\Inspection\CheckList\Module\Sub;

use App\Domain\Inspection\CheckList\Control\CheckListControl;
use App\Domain\Inspection\CheckList\Module\CheckListModule;
use Illuminate\Database\Eloquent\Model;

class CheckListSubModule extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'module_id',
        'name',
        'columns'
    ];

    public function module()
    {
        return $this->belongsTo(CheckListModule::class,'module_id','id');
    }

    public function controls()
    {
        return $this->hasMany(CheckListControl::class,'sub_module_id','id');
    }
}
