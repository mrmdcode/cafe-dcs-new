<?php
namespace App\Http\Controllers\API\Company;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{
    public function getMenuItems(Menu $menu)
    {
        $companyID = Auth::user()->company_id;

        if ($menu->company_id !== $companyID) {
            abort(403, 'Unauthorized');
        }

        $items = $menu->MenuItem()->get(['id', 'name', 'price']);

        return response()->json($items);
    }
}
