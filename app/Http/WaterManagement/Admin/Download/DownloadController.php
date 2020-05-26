<?php

namespace App\Http\WaterManagement\Admin\Download;

use App\Domain\Data\Export\ExportReminder;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;

class DownloadController extends Controller
{
    public function index()
    {
        return view('water-management.admin.download.index');
    }
}
