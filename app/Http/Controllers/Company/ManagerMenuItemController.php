<?php
namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\Printer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ManagerMenuItemController extends Controller
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
        $menu = Menu::where('id', $request->input('menu_id'))->first();
        if (is_null($menu)) {
            session()->flash('status', 'error');
            session()->flash('message', 'منو وجود ندارد به پشتیبانی اطلاع دهید .');
            return redirect()->route('company.category.index');
        }
        if ($menu->company_id != auth()->user()->company_id) {
            session()->flash('status', 'error');
            session()->flash('message', 'در سیستم خطا به وجود آمده ، به پشتیبانی اطلاع دهید .');
            return redirect()->route('company.category.index');
        }
        $category = Category::where('id', $request->input('category_id'))->first();
        if (is_null($category)) {
            session()->flash('status', 'error');
            session()->flash('message', 'دسته بندی وجود ندارد به پشتیبانی اطلاع دهید .');
            return redirect()->route('company.category.index');
        }
        if ($category->company_id != auth()->user()->company_id) {
            session()->flash('status', 'error');
            session()->flash('message', 'در سیستم خطا به وجود آمده ، به پشتیبانی اطلاع دهید .');
            return redirect()->route('company.category.index');
        }
        $printer = Printer::where('id', $request->input('printer_id'))->first();
        if (is_null($printer)) {
            session()->flash('status', 'error');
            session()->flash('message', 'پرینتر وجود ندارد به پشتیبانی اطلاع دهید .');
            return redirect()->route('company.category.index');
        }
        if ($printer->company_id != auth()->user()->company_id) {
            session()->flash('status', 'error');
            session()->flash('message', 'در سیستم خطا به وجود آمده ، به پشتیبانی اطلاع دهید .');
            return redirect()->route('company.category.index');
        }
        $path = null;
        if ($request->file('image')) {

            $file = $request->file('image');
            $path = time() . '_' . $request->name . '.' . $file->getClientOriginalExtension();
            Storage::disk('local')->put('public/' . $path, file_get_contents($file));
        }
        MenuItem::create([
            'company_id'           => auth()->user()->company_id,
            'category_id'          => $request->input('category_id'),
            'menu_id'              => $request->input('menu_id'),
            'printer_id'           => $request->input('printer_id'),
            'name'                 => $request->input('name'),
            'name_en'              => $request->input('name_en', null),
            'price'                => $request->input('price'),
            'active'               => true,
            'description'          => $request->input('description', null),
            'description_en'       => $request->input('description_en', null),
            'show_customer'        => $request->input('show_customer'),
            'show_order_recipient' => $request->input('show_order_recipient'),
            'image'                => $path,
            'rost_time'            => $request->input('rost_time', null),
        ]);
        session()->flash('status', 'success');
        session()->flash('message', 'آیتم شما در منوی ' . $menu->name . " با نام " . $request->input('name') . ' ساخته شد .');
        return redirect()->route('company.category.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $menu_item = MenuItem::where('id', $id)->first();
        if (is_null($menu_item)) {
            session()->flash('status', 'error');
            session()->flash('message', 'منو وجود ندارد به پشتیبانی اطلاع دهید .');
            return redirect()->route('company.category.index');
        }
        if ($menu_item->company_id != auth()->user()->company_id) {
            session()->flash('status', 'error');
            session()->flash('message', 'در سیستم خطا به وجود آمده ، به پشتیبانی اطلاع دهید .');
            return redirect()->route('company.category.index');
        }
        return response()->json(compact('menu_item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $menu = Menu::where('id', $request->input('menu_id'))->first();
        if (is_null($menu)) {
            session()->flash('status', 'error');
            session()->flash('message', 'منو وجود ندارد به پشتیبانی اطلاع دهید .');
            return redirect()->route('company.category.index');
        }
        if ($menu->company_id != auth()->user()->company_id) {
            session()->flash('status', 'error');
            session()->flash('message', 'در سیستم خطا به وجود آمده ، به پشتیبانی اطلاع دهید .');
            return redirect()->route('company.category.index');
        }
        $category = Category::where('id', $request->input('category_id'))->first();
        if (is_null($category)) {
            session()->flash('status', 'error');
            session()->flash('message', 'دسته بندی وجود ندارد به پشتیبانی اطلاع دهید .');
            return redirect()->route('company.category.index');
        }
        if ($category->company_id != auth()->user()->company_id) {
            session()->flash('status', 'error');
            session()->flash('message', 'در سیستم خطا به وجود آمده ، به پشتیبانی اطلاع دهید .');
            return redirect()->route('company.category.index');
        }
        $printer = Printer::where('id', $request->input('printer_id'))->first();
        if (is_null($printer)) {
            session()->flash('status', 'error');
            session()->flash('message', 'دسته بندی وجود ندارد به پشتیبانی اطلاع دهید .');
            return redirect()->route('company.category.index');
        }
        if ($printer->company_id != auth()->user()->company_id) {
            session()->flash('status', 'error');
            session()->flash('message', 'در سیستم خطا به وجود آمده ، به پشتیبانی اطلاع دهید .');
            return redirect()->route('company.category.index');
        }
        $menu_item = MenuItem::where('id', $id)->first();
        if (is_null($menu_item)) {
            session()->flash('status', 'error');
            session()->flash('message', 'آیتم وجود ندارد به پشتیبانی اطلاع دهید .');
            return redirect()->route('company.category.index');
        }
        if ($menu_item->company_id != auth()->user()->company_id) {
            session()->flash('status', 'error');
            session()->flash('message', 'در سیستم خطا به وجود آمده ، به پشتیبانی اطلاع دهید .');
            return redirect()->route('company.category.index');
        }
        if ($request->file('image')) {
            $file = $request->file('image');
            $path = time() . '_' . $request->name . '.' . $file->getClientOriginalExtension();
            Storage::disk('local')->put('public/' . $path, file_get_contents($file));
            $menu_item->image = $path;
        }
        $menu_item->category_id          = $request->input('category_id');
        $menu_item->menu_id              = $request->input('menu_id');
        $menu_item->printer_id           = $request->input('printer_id');
        $menu_item->name                 = $request->input('name');
        $menu_item->name_en              = $request->input('name_en', null);
        $menu_item->price                = $request->input('price');
        $menu_item->active               = true;
        $menu_item->description          = $request->input('description', null);
        $menu_item->description_en       = $request->input('description_en', null);
        $menu_item->show_customer        = $request->input('show_customer');
        $menu_item->show_order_recipient = $request->input('show_order_recipient');

        $menu_item->rost_time = $request->input('rost_time', null);
        $menu_item->update();
        session()->flash('status', 'success');
        session()->flash('message', 'آیتم' . $menu_item->name . " با موفقیت بروزرسانی شد.");
        return redirect()->route('company.category.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $menu_item = MenuItem::where('id', $id)->first();
        if (is_null($menu_item)) {
            session()->flash('status', 'error');
            session()->flash('message', 'منو وجود ندارد به پشتیبانی اطلاع دهید .');
            return redirect()->route('company.category.index');
        }
        if ($menu_item->company_id != auth()->user()->company_id) {
            session()->flash('status', 'error');
            session()->flash('message', 'در سیستم خطا به وجود آمده ، به پشتیبانی اطلاع دهید .');
            return redirect()->route('company.category.index');
        }
        $menu_item->delete();
        session()->flash('status', 'success');
        session()->flash('message', 'آیتم با موفقیت حذف شد .');
        return redirect()->route('company.category.index');
    }
    public function sor_hide(string $id)
    {
        $menu_item = MenuItem::where('id', $id)->first();
        if (is_null($menu_item)) {
            session()->flash('status', 'error');
            session()->flash('message', 'منو وجود ندارد به پشتیبانی اطلاع دهید .');
            return redirect()->route('company.category.index');
        }
        if ($menu_item->company_id != auth()->user()->company_id) {
            session()->flash('status', 'error');
            session()->flash('message', 'در سیستم خطا به وجود آمده ، به پشتیبانی اطلاع دهید .');
            return redirect()->route('company.category.index');
        }
        if ($menu_item->show_customer == 1) {
            session()->flash('status', 'error');
            session()->flash('message', 'برای ثبت منو اول باید سفارش گیر قابلیت دیدن آن را داشته باشد ، در صورت نیاز با پشتیبانی تماس بگیرید . ');
            return redirect()->route('company.category.index');
        }
        $menu_item->show_order_recipient = 0;
        $menu_item->update();
        session()->flash('status', 'success');
        session()->flash('message', ' (منو با موفقیت بروزرسانی شد . (سفارشگیر در پیتفرم دیگر این منو را مشاهده نمیکند .');
        return redirect()->route('company.category.index');

    }
    public function sor_show(string $id)
    {
        $menu_item = MenuItem::where('id', $id)->first();
        if (is_null($menu_item)) {
            session()->flash('status', 'error');
            session()->flash('message', 'منو وجود ندارد به پشتیبانی اطلاع دهید .');
            return redirect()->route('company.category.index');
        }
        if ($menu_item->company_id != auth()->user()->company_id) {
            session()->flash('status', 'error');
            session()->flash('message', 'در سیستم خطا به وجود آمده ، به پشتیبانی اطلاع دهید .');
            return redirect()->route('company.category.index');
        }

        $menu_item->show_order_recipient = 1;
        $menu_item->update();
        session()->flash('status', 'success');
        session()->flash('message', ' (منو با موفقیت بروزرسانی شد . (منو برای سفارشگیر قابل مشاهده شد   .');
        return redirect()->route('company.category.index');

    }
    public function sc_hide(string $id)
    {
        $menu_item = MenuItem::where('id', $id)->first();
        if (is_null($menu_item)) {
            session()->flash('status', 'error');
            session()->flash('message', 'منو وجود ندارد به پشتیبانی اطلاع دهید .');
            return redirect()->route('company.category.index');
        }
        if ($menu_item->company_id != auth()->user()->company_id) {
            session()->flash('status', 'error');
            session()->flash('message', 'در سیستم خطا به وجود آمده ، به پشتیبانی اطلاع دهید .');
            return redirect()->route('company.category.index');
        }
        if ($menu_item->show_order_recipient == 0) {
            session()->flash('status', 'error');
            session()->flash('message', 'برای ثبت منو اول باید سفارش گیر قابلیت دیدن آن را داشته باشد ، در صورت نیاز با پشتیبانی تماس بگیرید . ');
            return redirect()->route('company.category.index');
        }
        $menu_item->show_customer = 0;
        $menu_item->update();
        session()->flash('status', 'success');
        session()->flash('message', ' (منو با موفقیت بروزرسانی شد . (سفارشگیر در پیتفرم دیگر این منو را مشاهده نمیکند .');
        return redirect()->route('company.category.index');

    }
    public function sc_show(string $id)
    {
        $menu_item = MenuItem::where('id', $id)->first();
        if (is_null($menu_item)) {
            session()->flash('status', 'error');
            session()->flash('message', 'منو وجود ندارد به پشتیبانی اطلاع دهید .');
            return redirect()->route('company.category.index');
        }
        if ($menu_item->company_id != auth()->user()->company_id) {
            session()->flash('status', 'error');
            session()->flash('message', 'در سیستم خطا به وجود آمده ، به پشتیبانی اطلاع دهید .');
            return redirect()->route('company.category.index');
        }
        if ($menu_item->show_order_recipient == 0) {
            session()->flash('status', 'error');
            session()->flash('message', 'برای ثبت منو اول باید سفارش گیر قابلیت دیدن آن را داشته باشد ، در صورت نیاز با پشتیبانی تماس بگیرید . ');
            return redirect()->route('company.category.index');
        }
        $menu_item->show_customer = 1;
        $menu_item->update();
        session()->flash('status', 'success');
        session()->flash('message', ' (منو با موفقیت بروزرسانی شد . (منو برای مشتریان قابل مشاهده شد   .');
        return redirect()->route('company.category.index');

    }

    public function de_active(string $id)
    {
        $menu_item = MenuItem::where('id', $id)->first();
        if (is_null($menu_item)) {
            session()->flash('status', 'error');
            session()->flash('message', 'منو وجود ندارد به پشتیبانی اطلاع دهید .');
            return redirect()->route('company.category.index');
        }
        if ($menu_item->company_id != auth()->user()->company_id) {
            session()->flash('status', 'error');
            session()->flash('message', 'در سیستم خطا به وجود آمده ، به پشتیبانی اطلاع دهید .');
            return redirect()->route('company.category.index');
        }
        $menu_item->active = 0;
        $menu_item->update();
        session()->flash('status', 'success');
        session()->flash('message', ' ( آیتم با موفقیت بروزرسانی شد . ( در منو ناموجود شد .');
        return redirect()->route('company.category.index');
    }
    public function active(string $id)
    {
        $menu_item = MenuItem::where('id', $id)->first();
        if (is_null($menu_item)) {
            session()->flash('status', 'error');
            session()->flash('message', 'منو وجود ندارد به پشتیبانی اطلاع دهید .');
            return redirect()->route('company.category.index');
        }
        if ($menu_item->company_id != auth()->user()->company_id) {
            session()->flash('status', 'error');
            session()->flash('message', 'در سیستم خطا به وجود آمده ، به پشتیبانی اطلاع دهید .');
            return redirect()->route('company.category.index');
        }
        $menu_item->active = 1;
        $menu_item->update();
        session()->flash('status', 'success');
        session()->flash('message', ' ( آیتم با موفقیت بروزرسانی شد . ( در منو ناموجود شد .');
        return redirect()->route('company.category.index');
    }
}
