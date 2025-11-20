<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Printer;
use Illuminate\Http\Request;

class ManagerPrinterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $printers = Printer::where('company_id',auth()->user()->company_id)->get();
        $is_update = [];
        return view('dashboard.company.manager.printers',compact('printers','is_update'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Printer::create([
            'company_id'=>auth()->user()->company_id,
            'name'=>$request->input('name'),
            'local_address'=>$request->input('local_address'),
            'cashier'=>$request->input('cashier')
        ]);
        session()->flash('status','success');
        session()->flash('message','پیرنتر با موفقیت ایجاد شد.');
        return redirect()->route('company.printer.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $printer = Printer::where('id',$id)->first();
        if (is_null($printer)){
            session()->flash('status','error');
            session()->flash('message','پرینتر وجود ندارد به پشتیبانی اطلاع دهید .');
            return redirect()->route('company.printer.index');
        }
        if ($printer->company_id != auth()->user()->company_id){
            session()->flash('status','error');
            session()->flash('message','در سیستم خطا به وجود آمده ، به پشتیبانی اطلاع دهید .');
            return redirect()->route('company.printer.index');
        }
        $printers = Printer::where('company_id',auth()->user()->company_id)->get();
        $is_update = $printer;

        return view('dashboard.company.manager.printers',compact('printers','is_update'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $printer = Printer::where('id',$id)->first();
        if (is_null($printer)){
            session()->flash('status','error');
            session()->flash('message','پرینتر وجود ندارد به پشتیبانی اطلاع دهید .');
            return redirect()->route('company.printer.index');
        }
        if ($printer->company_id != auth()->user()->company_id){
            session()->flash('status','error');
            session()->flash('message','در سیستم خطا به وجود آمده ، به پشتیبانی اطلاع دهید .');
            return redirect()->route('company.printer.index');
        }
        $printer->name = $request->input('name');
        $printer->local_address = $request->input('local_address');
        $printer->cashier = $request->input('cashier');
        $printer->update();
        session()->flash('status','success');
        session()->flash('message','پرینتر با موفقیت ویرایش شد .');
        return redirect()->route('company.printer.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $printer = Printer::where('id',$id)->first();
        if (is_null($printer)){
            session()->flash('status','error');
            session()->flash('message','پرینتر وجود ندارد به پشتیبانی اطلاع دهید .');
            return redirect()->route('company.printer.index');
        }
        if ($printer->company_id != auth()->user()->company_id){
            session()->flash('status','error');
            session()->flash('message','در سیستم خطا به وجود آمده ، به پشتیبانی اطلاع دهید .');
            return redirect()->route('company.printer.index');
        }
        if ($printer->MenuItem()->count() >= 1){
            session()->flash('status','error');
            session()->flash('message',' آیتم های خط آشپرخانه را از به پرینتر دیگری منتقل کرده و سپس مجدد امتحان کنید .');
            return redirect()->route('company.printer.index');
        }
        $printer->delete();
        session()->flash('status','success');
        session()->flash('message','پرینتر با موفقیت حذف شد .');
        return redirect()->route('company.printer.index');
    }
}
