<?php

namespace App\Domain\System\File;

use App\Domain\System\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class File extends Model implements Auditable
{
    use SoftDeletes, \OwenIt\Auditing\Auditable;
    protected $dates = ['deleted_at'];
    protected $fillable= [
        'user_id','referenced_table','referenced_id','file','extension','is_unique'
    ];

    public function getFullPath()
    {
        return $this->getDirectory().$this->file;
    }

    public function getDirectory()
    {
        if ($this->referenced_table != '') {
            $directory = $this->referenced_table.'/';
        } else {
            $directory = 'misc/';
        }
        return 'filesUploaded/'.$directory;
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public static function findByTableAndId($table,$id)
    {
        return static::where(['referenced_table' => $table, 'referenced_id' => $id])->first();
    }
}
