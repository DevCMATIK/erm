<?php

namespace App\App\Traits\Scopes;


trait HasSearchScopes
{
    public function scopeSearch($query,$field, $parameter)
    {
        return $query->whereIn($field,$parameter);
    }

}
