<?php

namespace App\Domain\System\Mail;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class MailAttachable extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    public $timestamps = false;

    protected $fillable = [
        'code',
        'name'
    ];

    public function mails()
    {
        return $this->belongsToMany(Mail::class,'mail_attached_values','mail_attachable_id','mail_id');
    }
}
