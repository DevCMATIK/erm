<?php

namespace App\Domain\Data\Export;

use Illuminate\Database\Eloquent\Model;

class ExportReminderFile extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'export_reminder_id',
        'file',
        'display_name'
    ];

    public function reminder()
    {
        return $this->belongsTo(ExportReminder::class,'export_reminder_id','id');
    }
}
