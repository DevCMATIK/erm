<?php

namespace App\Domain\System\Mail;

use App\Domain\System\User\User;
use Illuminate\Database\Eloquent\Model;

class MailLogUser extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'log_id',
        'user_id'
    ];

    public function log()
    {
        return $this->belongsTo(MailLog::class,'log_id','id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
