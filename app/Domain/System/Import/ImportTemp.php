<?php

namespace App\Domain\System\Import;

use Illuminate\Database\Eloquent\Model;

class ImportTemp extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'import_file_id','row_num','data','processed','feedback'
    ];

    public function import_file()
    {
        return $this->belongsTo(ImportFile::class,'import_file_id','id');
    }

    public function scopeProcessed($query,$processed = 1)
    {
        return $query->where('processed',$processed);
    }

    public static function deleteDoned()
    {
        return static::where('processed',1)->whereNull('feedback')->orWhere('feedback','0')->delete();
    }
}
