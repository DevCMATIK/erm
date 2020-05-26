<?php

namespace App\Http\System\User\Controllers;

use App\App\Controllers\Controller;
use App\Exports\System\User\UsersExport;
use Excel;

class ExportUsersController extends Controller
{
    public function __invoke()
    {
        return Excel::download(new UsersExport(), 'users.xlsx');
    }
}
