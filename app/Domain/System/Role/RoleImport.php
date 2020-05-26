<?php

namespace App\Domain\System\Role;

use Illuminate\Database\Eloquent\Model;

class RoleImport extends Model
{
    public $timestamps = false;

    protected $fillable = ['role_id','import_id'];
}
