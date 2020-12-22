<?php

namespace App\Domain\Client\ProductionArea;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ProductionAreaZone extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    //
}
