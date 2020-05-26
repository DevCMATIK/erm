<?php

namespace App\Http\System\Permission\Controllers;

use App\Exports\System\Permission\PermissionsExport;
use App\App\Controllers\Controller;
use Excel;

class ExportPermissionsController extends Controller
{
    public function __invoke()
    {
        return Excel::download(new PermissionsExport(), 'permissions.xlsx');
    }
}
