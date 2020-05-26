<?php

namespace App\Http\System\Role\Controllers;

use App\App\Controllers\Controller;
use App\Exports\System\Role\RolesExport;
use Excel;

class ExportRolesController extends Controller
{

	public function __invoke()
	{
		return Excel::download(new RolesExport(), 'roles.xlsx');
	}
}
