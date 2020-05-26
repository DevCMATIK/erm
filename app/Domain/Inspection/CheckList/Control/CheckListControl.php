<?php

namespace App\Domain\Inspection\CheckList\Control;

use App\Domain\Inspection\CheckList\Module\Sub\CheckListSubModule;
use Illuminate\Database\Eloquent\Model;

class CheckListControl extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'sub_module_id',
        'name',
        'values',
        'type',
        'metric',
        'is_required'
    ];

    public function sub_module()
    {
        return $this->belongsTo(CheckListSubModule::class,'sub_module_id','id');
    }
}
