<?php

namespace App\Domain\System\Mail;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class MailAttachedValue extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    //
}
