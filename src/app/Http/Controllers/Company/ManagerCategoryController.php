<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\Printer;
use App\Models\User;
use Illuminate\Http\Request;

class ManagerCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category = Category::where("company_id",auth()->user()->company_id)->get();
        $menu = Menu::where("company_id",auth()->user()->company_id)->get();
        $menu_item =MenuItem::where("company_id",auth()->user()->company_id)->get();
        $printer = Printer::where("company_id",auth()->user()->company_id)->get();
        return view('dashboard.company.manager.menu_action',
            compact('printer','category','menu','menu_item'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Category::create([
            'company_id'=>auth()->user()->company_id,
            'name'=>$request->input('name'),
            'name_en'=>$request->input('name_en')
        ]);
        session()->flash('status','success');
        session()->flash('message','دسته بندی با موفقیت ایجاد شد.');
        return redirect()->route('company.category.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::where('id',$id)->first();
        if (is_null($category)){
            session()->flash('status','error');
            session()->flash('message','دسته بندی وجود ندارد به پشتیبانی اطلاع دهید .');
            return redirect()->route('company.category.index');
        }
        if ($category->company_id != auth()->user()->company_id){
            session()->flash('status','error');
            session()->flash('message','در سیستم خطا به وجود آمده ، به پشتیبانی اطلاع دهید .');
            return redirect()->route('company.category.index');
        }
        return response()->json(compact('category'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = Category::where('id',$id)->first();
        if (is_null($category)){
            session()->flash('status','error');
            session()->flash('message','دسته بندی وجود ندارد به پشتیبانی اطلاع دهید .');
            return redirect()->route('company.category.index');
        }
        if ($category->company_id != auth()->user()->company_id){
            session()->flash('status','error');
            session()->flash('message','در سیستم خطا به وجود آمده ، به پشتیبانی اطلاع دهید .');
            return redirect()->route('company.category.index');
        }
        $category->name = $request->input('name');
        $category->name_en = $request->input('name_en');
        $category->update();
        session()->flash('status','success');
        session()->flash('message','دسته بندی با موفقیت بروزرسانی شد.');
        return redirect()->route('company.category.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::where('id',$id)->first();
        if (is_null($category)){
            session()->flash('status','error');
            session()->flash('message','دسته بندی وجود ندارد به پشتیبانی اطلاع دهید .');
            return redirect()->route('company.category.index');
        }
        if ($category->company_id != auth()->user()->company_id){
            session()->flash('status','error');
            session()->flash('message','در سیستم خطا به وجود آمده ، به پشتیبانی اطلاع دهید .');
            return redirect()->route('company.category.index');
        }
             // 1 > 0 true 1 >= 0
        if ($category->MenuItem()->count()   >= 1){
            session()->flash('status','error');
            session()->flash('message','آیتم های وابسته به دسته بندی را ویرایش یا حذف کنید .');
            return redirect()->route('company.category.index');
        }
        $category->delete();
        session()->flash('status','success');
        session()->flash('message','دسته بندی با موفقیت حذف شد .');
        return redirect()->route('company.category.index');
    }
}
