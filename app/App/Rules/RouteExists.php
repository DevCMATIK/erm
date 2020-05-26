<?php

namespace App\App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Route;

class RouteExists implements Rule
{
    public function passes($attribute, $value)
    {
        return ($value != '')?Route::has($value):true;
    }

    public function message()
    {
        return trans('validation.route');
    }
}
