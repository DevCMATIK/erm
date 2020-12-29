<?php

namespace App\Domain\System\Audit;

use App\App\Traits\Scopes\HasSearchScopes;

class Audit extends \OwenIt\Auditing\Models\Audit
{
    use HasSearchScopes;
    //
}
