<?php

namespace App\Domain\System\Mail;

use Illuminate\Database\Eloquent\Model;

class MailLog extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'mail_id',
        'mail_name',
        'identifier',
        'date'
    ];

    public function  mail()
    {
        return $this->belongsTo(Mail::class,'mail_id','id');
    }

    public function users()
    {
        return $this->hasMany(MailLogUser::class,'log_id','id');
    }
}
