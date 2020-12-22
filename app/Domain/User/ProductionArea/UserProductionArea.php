<?php

namespace App\Domain\User\ProductionArea;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class UserProductionArea extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    //
}
