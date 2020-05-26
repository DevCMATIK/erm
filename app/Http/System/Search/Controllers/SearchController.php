<?php

namespace App\Http\System\Search\Controllers;

use App\Domain\Supplier\PurchasingOrder\PurchasingOrder;
use App\Domain\Supplier\Supplier;
use Illuminate\Http\Request;
use App\App\Controllers\Controller;

class SearchController extends Controller
{
    public function __invoke($toFind)
    {
        if (is_numeric($toFind)) {
            $po = PurchasingOrder::withPendingItems($toFind);
            return view('system.search.results', compact(['toFind','po']));
        } else {
            $suppliers = Supplier::where('rut',$toFind)
                ->orWhere('name','like','%'.$toFind.'%')
                ->take(5)
                ->get();
            return view('system.search.results', compact(['toFind','suppliers']));
        }
    }
}
