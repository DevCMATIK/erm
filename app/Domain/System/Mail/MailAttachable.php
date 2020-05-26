<?php

namespace App\Domain\System\Mail;

use Illuminate\Database\Eloquent\Model;

class MailAttachable extends Model
{
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
