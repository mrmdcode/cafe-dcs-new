<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Order;
use Illuminate\Http\Request;

class SiteLayoutsController extends Controller
{
    public function check_order($company_username, $order_id,$order_unique_key)
    {
        $company = Company::where('username',$company_username)->firstOrFail();
//        return $order = Order::where('company_id',$company->id)->where('id',$order_id)->where('unique_key',$order_unique_key)->with(['menu_item.menu'])->first();
        $order = Order::withTrashed()->where('company_id',$company->id)->where('id',$order_id)->where('unique_key',$order_unique_key)->with(['menu_item.menu'=>function ($query) {
        $query->withTrashed();
    }])->withTrashed()->first();
        return view('invoice.check_order',compact('company','order'));
    }
}
