<?php

namespace App\Domain\Inspection\CheckList\Module;

use App\Domain\Inspection\CheckList\CheckList;
use App\Domain\Inspection\CheckList\Module\Sub\CheckListSubModule;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class CheckListModule extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    public $timestamps =  false;

    protected $fillable = [
        'check_list_id',
        'name',
        'position'
    ];

    public function check_list()
    {
        return $this->belongsTo(CheckList::class,'check_list_id','id');
    }

    public function sub_modules()
    {
        return $this->hasMany(CheckListSubModule::class,'module_id','id');
    }
}
