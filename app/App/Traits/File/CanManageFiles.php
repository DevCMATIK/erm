<?php

namespace App\App\Traits\File;

use App\Domain\System\File\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Sentinel;

trait CanManageFiles
{
    private $fileName;

    private $fileDirectory;

    protected function setFileDirectory($directory)
    {
        $this->fileDirectory = $directory;
    }

    protected function setFileName($from)
    {
        if(stristr($from,'/')) {
            $prefix = explode('/',$from)[1];
        } else {
            $prefix = $from;
        }

        $this->fileName = config('app.name')."_".$prefix."_".md5(rand(0,1000)).".".$this->extension;
    }

    public function getFileDirectory()
    {
        return $this->fileDirectory;
    }

    public function getFileName()
    {
        return $this->fileName;
    }

    public function getfullPath()
    {
        if(isset($this->fileName) && isset($this->fileDirectory)){
            return $this->fileDirectory.$this->fileName;
        }
        return response()->json(['error' => 'No se ha definido el directorio.'],401);
    }

}
