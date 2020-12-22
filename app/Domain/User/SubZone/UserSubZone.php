<?php

namespace App\Domain\User\SubZone;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class UserSubZone extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

}
