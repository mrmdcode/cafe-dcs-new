<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Menu;
use Illuminate\Http\Request;

class ManagerMenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return redirect()->route('company.category.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->input('show_order_recipient') != 1 && $request->input('show_customer') == 1){
            session()->flash('status','error');
            session()->flash('message','برای ثبت منو اول باید سفارش گیر قابلیت دیدن آن را داشته باشد ، در صورت نیاز با پشتیبانی تماس بگیرید . ');
            return redirect()->route('company.category.index');
        }
        Menu::create([
            'company_id' => auth()->user()->company_id,
            'name' => $request->input('name'),
            'name_en' => $request->input('name_en'),
            'description' => $request->input('description'),
            'show_customer' => $request->input('show_customer'),
            'show_order_recipient' => $request->input('show_order_recipient'),

        ]);
        session()->flash('status','success');
        session()->flash('message','ساخت منو با موفقیت انجام شد .');
        return redirect()->route('company.category.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $menu = Menu::where('id',$id)->first();
        if (is_null($menu)){
            session()->flash('status','error');
            session()->flash('message','منو وجود ندارد به پشتیبانی اطلاع دهید .');
            return redirect()->route('company.category.index');
        }
        if ($menu->company_id != auth()->user()->company_id){
            session()->flash('status','error');
            session()->flash('message','در سیستم خطا به وجود آمده ، به پشتیبانی اطلاع دهید .');
            return redirect()->route('company.category.index');
        }
        return response()->json(compact('menu'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $menu = Menu::where('id',$id)->first();
        if (is_null($menu)){
            session()->flash('status','error');
            session()->flash('message','منو وجود ندارد به پشتیبانی اطلاع دهید .');
            return redirect()->route('company.category.index');
        }
        if ($menu->company_id != auth()->user()->company_id){
            session()->flash('status','error');
            session()->flash('message','در سیستم خطا به وجود آمده ، به پشتیبانی اطلاع دهید .');
            return redirect()->route('company.category.index');
        }
        if ($request->input('show_order_recipient') != 1 && $request->input('show_customer') == 1){
            session()->flash('status','error');
            session()->flash('message','برای ثبت منو اول باید سفارش گیر قابلیت دیدن آن را داشته باشد ، در صورت نیاز با پشتیبانی تماس بگیرید . ');
            return redirect()->route('company.category.index');
        }
        $menu->name = $request->input('name');
        $menu->name_en = $request->input('name_en');
        $menu->description = $request->input('description');
        $menu->show_customer = $request->input('show_customer');
        $menu->show_order_recipient = $request->input('show_order_recipient');
        $menu->update();
        session()->flash('status','success');
        session()->flash('message','منو با موفقیت بروزرسانی شد.');
        return redirect()->route('company.category.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $menu = Menu::where('id',$id)->first();
        if (is_null($menu)){
            session()->flash('status','error');
            session()->flash('message','منو وجود ندارد به پشتیبانی اطلاع دهید .');
            return redirect()->route('company.category.index');
        }
        if ($menu->company_id != auth()->user()->company_id){
            session()->flash('status','error');
            session()->flash('message','در سیستم خطا به وجود آمده ، به پشتیبانی اطلاع دهید .');
            return redirect()->route('company.category.index');
        }
        if ($menu->MenuItem()->count()   >= 1){
            session()->flash('status','error');
            session()->flash('message','آیتم های وابسته به منو را ویرایش یا حذف کنید .');
            return redirect()->route('company.category.index');
        }
        $menu->delete();
        session()->flash('status','success');
        session()->flash('message','منو با موفقیت حذف شد .');
        return redirect()->route('company.category.index');
    }

    public function sor_hide(string $id)
    {
        $menu = Menu::where('id',$id)->first();
        if (is_null($menu)){
            session()->flash('status','error');
            session()->flash('message','منو وجود ندارد به پشتیبانی اطلاع دهید .');
            return redirect()->route('company.category.index');
        }
        if ($menu->company_id != auth()->user()->company_id){
            session()->flash('status','error');
            session()->flash('message','در سیستم خطا به وجود آمده ، به پشتیبانی اطلاع دهید .');
            return redirect()->route('company.category.index');
        }
        if ($menu->show_customer == 1){
            session()->flash('status','error');
            session()->flash('message','برای ثبت منو اول باید سفارش گیر قابلیت دیدن آن را داشته باشد ، در صورت نیاز با پشتیبانی تماس بگیرید . ');
            return redirect()->route('company.category.index');
        }
        $menu->show_order_recipient =0 ;
        $menu->update();
        session()->flash('status','success');
        session()->flash('message',' (منو با موفقیت بروزرسانی شد . (سفارشگیر در پیتفرم دیگر این منو را مشاهده نمیکند .');
        return redirect()->route('company.category.index');

    }
    public function sor_show(string $id)
    {
        $menu = Menu::where('id',$id)->first();
        if (is_null($menu)){
            session()->flash('status','error');
            session()->flash('message','منو وجود ندارد به پشتیبانی اطلاع دهید .');
            return redirect()->route('company.category.index');
        }
        if ($menu->company_id != auth()->user()->company_id){
            session()->flash('status','error');
            session()->flash('message','در سیستم خطا به وجود آمده ، به پشتیبانی اطلاع دهید .');
            return redirect()->route('company.category.index');
        }

        $menu->show_order_recipient =1 ;
        $menu->update();
        session()->flash('status','success');
        session()->flash('message',' (منو با موفقیت بروزرسانی شد . (منو برای سفارشگیر قابل مشاهده شد   .');
        return redirect()->route('company.category.index');

    }
    public function sc_hide(string $id)
    {
        $menu = Menu::where('id',$id)->first();
        if (is_null($menu)){
            session()->flash('status','error');
            session()->flash('message','منو وجود ندارد به پشتیبانی اطلاع دهید .');
            return redirect()->route('company.category.index');
        }
        if ($menu->company_id != auth()->user()->company_id){
            session()->flash('status','error');
            session()->flash('message','در سیستم خطا به وجود آمده ، به پشتیبانی اطلاع دهید .');
            return redirect()->route('company.category.index');
        }
        if ($menu->show_order_recipient == 0){
            session()->flash('status','error');
            session()->flash('message','برای ثبت منو اول باید سفارش گیر قابلیت دیدن آن را داشته باشد ، در صورت نیاز با پشتیبانی تماس بگیرید . ');
            return redirect()->route('company.category.index');
        }
        $menu->show_customer =0 ;
        $menu->update();
        session()->flash('status','success');
        session()->flash('message',' (منو با موفقیت بروزرسانی شد . (سفارشگیر در پیتفرم دیگر این منو را مشاهده نمیکند .');
        return redirect()->route('company.category.index');

    }
    public function sc_show(string $id)
    {
        $menu = Menu::where('id',$id)->first();
        if (is_null($menu)){
            session()->flash('status','error');
            session()->flash('message','منو وجود ندارد به پشتیبانی اطلاع دهید .');
            return redirect()->route('company.category.index');
        }
        if ($menu->company_id != auth()->user()->company_id){
            session()->flash('status','error');
            session()->flash('message','در سیستم خطا به وجود آمده ، به پشتیبانی اطلاع دهید .');
            return redirect()->route('company.category.index');
        }
        if ($menu->show_order_recipient == 0){
            session()->flash('status','error');
            session()->flash('message','برای ثبت منو اول باید سفارش گیر قابلیت دیدن آن را داشته باشد ، در صورت نیاز با پشتیبانی تماس بگیرید . ');
            return redirect()->route('company.category.index');
        }
        $menu->show_customer =1 ;
        $menu->update();
        session()->flash('status','success');
        session()->flash('message',' (منو با موفقیت بروزرسانی شد . (منو برای مشتریان قابل مشاهده شد   .');
        return redirect()->route('company.category.index');

    }

}
