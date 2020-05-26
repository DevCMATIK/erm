<?php

namespace App\Domain\System\Role;

use Illuminate\Database\Eloquent\Model;

class MenuRole extends Model
{
    public $timestamps = false;

    protected $fillable = ['menu_id','role_id'];
}
