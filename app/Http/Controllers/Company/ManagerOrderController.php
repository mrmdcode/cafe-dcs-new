<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ManagerOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.company.manager.orders');
    }
    public function indexData(Request $request)
    {
        $data = [];
        if ($request->input('today')){
            $data =  Order::withTrashed()->where('created_at','>',Carbon::today())->where('company_id',auth()->user()->company_id)->with(['table','customer','order_recipient','menu_item'=>function ($query) {
                $query->withTrashed();
            }])->get();
        }
        if ($request->input('yesterday')){
            $data =  Order::withTrashed()->where('created_at','<',Carbon::today())->where('created_at','>',Carbon::yesterday())->where('company_id',auth()->user()->company_id)->with(['table','customer','order_recipient','menu_item'=>function ($query) {
                $query->withTrashed();
            }])->get();
        }
        if ($request->input('older')){
            $data =  Order::withTrashed()->where('created_at','<',Carbon::yesterday())->where('company_id',auth()->user()->company_id)->with(['table','customer','order_recipient','menu_item'=>function ($query) {
                $query->withTrashed();
            }])->get();
        }
        if ($request->input('paid')){
            $data = $data->where('status','!=','registration')->where('status','!=','cancelled')->where('status','!=','edit');
        }

        return response()->json($data);
    }

    public function init_modal()
    {
        $company = Company::where('id',auth()->user()->company_id)->first();
        $menus = $company->Menu()->with('MenuItem')->get();
        return response()->json(compact('menus'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id,string $unique_key)
    {
        $data =  Order::withTrashed()->where('id',$id)->where('unique_key',$unique_key)->where('company_id',auth()->user()->company_id)->with(['table','customer','order_recipient','menu_item'=>function ($query) {
            $query->withTrashed();
        }])->first();
        return response()->json($data);
    }
    public function edit(string $id,string $unique_key)
    {
        $data =  Order::withTrashed()->where('id',$id)->where('unique_key',$unique_key)->where('company_id',auth()->user()->company_id)->with(['table','customer','order_recipient','menu_item'=>function ($query) {
            $query->withTrashed();
        }])->first();
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    public function paidding(string $id,string $unique_key)
    {
        $order = Order::where('id',$id)->where('unique_key',$unique_key)->first();
        if ($order->status == 'paid'){
            return response()->json('Order is already paid',409);
        }
        $order->status = 'paid';
        $order->save();
        return response()->json('',200);
    }
    public function finishing(string $id,string $unique_key)
    {
        $order = Order::where('id',$id)->where('unique_key',$unique_key)->first();
        if ($order->status == 'paid'){
            return response()->json('Order is already paid',409);
        }
        if ($order->status == 'finish'){
            return response()->json('Order is already finish',409);
        }
        $order->status = 'finish';
        $order->save();
        return response()->json('',200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
