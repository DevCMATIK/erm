<?php

namespace App\Domain\Inspection\CheckList\Module\Sub;

use App\Domain\Inspection\CheckList\Control\CheckListControl;
use App\Domain\Inspection\CheckList\Module\CheckListModule;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class CheckListSubModule extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

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
