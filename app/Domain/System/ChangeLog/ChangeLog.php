<?php

namespace App\Domain\System\ChangeLog;

use App\Domain\System\User\User;
use Illuminate\Database\Eloquent\Model;

class ChangeLog extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'table',
        'old_columns',
        'new_columns',
        'description',
        'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
