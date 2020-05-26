<?php

namespace App\Http\System\Menu\Controllers;

use App\App\Controllers\Controller;
use App\Exports\System\Menu\MenusExport;
use Excel;

class ExportMenusController extends Controller
{
	public function __invoke()
	{
		return Excel::download(new MenusExport(), 'menus.xlsx');
	}
}
