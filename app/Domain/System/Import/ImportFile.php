<?php

namespace App\Domain\System\Import;

use App\Domain\System\User\User;
use Illuminate\Database\Eloquent\Model;

class ImportFile extends Model
{
    protected $fillable = [
        'import_id','user_id','file','extension','imported','before_function','after_function'
    ];

    public function import()
    {
        return $this->belongsTo(Import::class,'import_id','id');
    }

    public function temps()
    {
        return $this->hasMany(ImportTemp::class,'import_file_id','id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function processed()
    {
        return $this->hasMany(ImportTemp::class)->where('import_temps.processed',1);
    }

    public function error_messages()
    {
        return $this->hasMany(ImportTemp::class)->whereNotNull('import_temps.feedback');
    }

    public function changeStatus($status = 2)
    {
        return $this->update(['imported' => $status]);
    }
}
