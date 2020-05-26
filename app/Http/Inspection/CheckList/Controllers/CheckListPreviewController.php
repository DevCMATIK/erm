<?php

namespace App\Http\Inspection\CheckList\Controllers;

use App\Domain\Inspection\CheckList\CheckList;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;

class CheckListPreviewController extends Controller
{
    public function index(Request $request)
    {
        $checkList = CheckList::findBySlug($request->slug)->with('modules.sub_modules.controls')->first();
        return view('inspection.check-list.preview.index',compact('checkList'));
    }
}
