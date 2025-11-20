<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Printer;
use App\Models\Table;
use Faker\Factory as Faker;
use Illuminate\Http\Request;

class ManagerTableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tables = Table::where("company_id",auth()->user()->company_id)->get();
        $is_update = [];
        return view('dashboard.company.manager.table',
            compact('tables','is_update'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $faker = Faker::create();
        $unique_key ='';
        for ($i = 1; $i <= rand(10,15); $i++) {
            $unique_key = $unique_key.$faker->randomLetter();

        }
        Table::create([
            'company_id'=>auth()->user()->company_id,
            'name'=>$request->input('name'),
            'capacity'=>$request->input('capacity'),
            'unique_key'=>$unique_key,
            'description'=>$request->input('description',null)
        ]);
        session()->flash('status','success');
        session()->flash('message','میز با موفقیت ایجاد شد.');
        return redirect()->route('company.table.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $table = Table::where('id',$id)->first();
        if (is_null($table)){
            session()->flash('status','error');
            session()->flash('message','پرینتر وجود ندارد به پشتیبانی اطلاع دهید .');
            return redirect()->route('company.printer.index');
        }
        if ($table->company_id != auth()->user()->company_id){
            session()->flash('status','error');
            session()->flash('message','در سیستم خطا به وجود آمده ، به پشتیبانی اطلاع دهید .');
            return redirect()->route('company.table.index');
        }
        $tables = Table::where('company_id',auth()->user()->company_id)->get();
        $is_update = $table;

        return view('dashboard.company.manager.table',compact('tables','is_update'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $table = Table::where('id',$id)->first();
        if (is_null($table)){
            session()->flash('status','error');
            session()->flash('message','میز وجود ندارد به پشتیبانی اطلاع دهید .');
            return redirect()->route('company.table.index');
        }
        if ($table->company_id != auth()->user()->company_id){
            session()->flash('status','error');
            session()->flash('message','در سیستم خطا به وجود آمده ، به پشتیبانی اطلاع دهید .');
            return redirect()->route('company.table.index');
        }
        $table->name = $request->input('name');
        $table->description = $request->input('description');
        $table->capacity = $request->input('capacity');
        $table->update();
        session()->flash('status','success');
        session()->flash('message','میز با موفقیت ویرایش شد .');
        return redirect()->route('company.table.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $table = Printer::where('id',$id)->first();
        if (is_null($table)){
            session()->flash('status','error');
            session()->flash('message','میز وجود ندارد به پشتیبانی اطلاع دهید .');
            return redirect()->route('company.table.index');
        }
        if ($table->company_id != auth()->user()->company_id){
            session()->flash('status','error');
            session()->flash('message','در سیستم خطا به وجود آمده ، به پشتیبانی اطلاع دهید .');
            return redirect()->route('company.table.index');
        }
        $table->delete();
        session()->flash('status','success');
        session()->flash('message','میز با موفقیت حذف شد .');
        return redirect()->route('company.table.index');


    }
}
