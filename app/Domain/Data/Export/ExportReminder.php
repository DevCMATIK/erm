<?php

namespace App\Domain\Data\Export;

use App\App\Traits\Dates\HasDateScopes;
use App\Domain\System\User\User;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ExportReminder extends Model implements Auditable
{
    use HasDateScopes, \OwenIt\Auditing\Auditable;

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'sensors',
        'from',
        'to',
        'creation_date',
        'expires_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function files()
    {
        return $this->hasMany(ExportReminderFile::class,'export_reminder_id','id');
    }


}
