<?php

namespace App\App\Traits\Alarms;



trait HasSearchScopes
{
    public function scopeSearch($query,$field, $parameter)
    {
        return $query->whereIn($field,$parameter);
    }

}
