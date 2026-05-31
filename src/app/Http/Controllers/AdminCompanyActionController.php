<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminCompanyActionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companies =  Company::all();
        return view('dashboard.admin.companies', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
//        return $request->all();
        $file = $request->file('image');
        $path = time() . '_' . $request->name . '.' . $file->getClientOriginalExtension();
        Storage::disk('local')->put('public/' . $path, file_get_contents($file));

        $comp1 = Company::create([
            'name' => $request->input('name'),
            'username' => $request->input('username'),
            'address' => $request->input('address'),
            'state' => $request->input('state'),
            'city' => $request->input('city'),
            'phone' => $request->input('phone'),
            'name_boss' => $request->input('name_boss'),
            'phone_boss' => $request->input('phone_boss'),
            'phone_representative' => $request->input('phone_representative'),
            'capacity' => $request->input('capacity'),
            'sm_tel' => $request->input('sm_tel',null),
            'sm_instagram' => $request->input('sm_instagram',null),
            'sm_telegram' => $request->input('sm_telegram',null),
            'sm_whatsapp' => $request->input('sm_whatsapp',null),
            'sm_twitter' => $request->input('sm_twitter',null),
            'sm_threads' => $request->input('sm_threads',null),
            'sm_website' => $request->input('sm_website',null),
            'zip' => $request->input('zip'),
            'lat' => $request->input('lat'),
            'long' => $request->input('long'),
            'plan_menu' => $request->input('plan_menu',false),
            'plan_order_taker' => $request->input('plan_order_taker',false),
            'plan_time_report' => $request->input('plan_time_report',false),
            'plan_online_order' => $request->input('plan_online_order',false),
            'plan_printer_control' => $request->input('plan_printer_control',false),
            'plan_preparation_notification' => $request->input('plan_preparation_notification',false),
            'active' => true,
            'fee_received' => $request->input('fee_received'),
            'image' => $path,
        ]);

        User::create([
            'name' => $request->input('name_boss'),
            'email' => $request->input('username')."@".env('MAIL_DOMAIN'),
            'family' =>'',
            'state' => $request->input('state'),
            'address' => $request->input('address'),
            'city' => $request->input('city'),
            'company_id' => $comp1->id,
            'phone_number' => $request->input('phone_boss'),
            'national_id' => '123456789',
            'telegram_phone' => $request->input('phone_boss'),
            'telegram_id' => null,
            'static_ip' => null,
            'work_status' => "permanent_employment",
            'position' => "manager",
            'password' => Hash::make('123456'),
        ]);

        session()->flash('status','success');
        session()->flash('message',' ایجاد کافه و مدیریت با موفقیت انجام شد .');
        return redirect()->route('companies.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if (!Company::where('id', $id)->exists()) {
            session()->flash('status','error');
            session()->flash('message','کافه پیدا نشد .');
            return redirect()->route('companies.index');
        }
        $company = Company::where('id', $id)->first();
        if ($company->active == 0) {
            session()->flash('status','error');
            session()->flash('message','کافه فعال نیست .');
            return redirect()->route('companies.index');
        }
        return view('dashboard.admin.company_show', compact('company'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!Company::where('id', $id)->exists()) {
            session()->flash('status','error');
            session()->flash('message','کافه پیدا نشد .');
            return redirect()->route('companies.index');
        }
        $company = Company::where('id', $id)->first();
        if ($company->deleted_at) {
            session()->flash('status','error');
            session()->flash('message','کافه در حالت حذف است .');
            return redirect()->route('companies.index');
        }
        $company->active = 0;
        $company->deleted_at = Carbon::now();
        $company->save();
        session()->flash('status','success');
        session()->flash('message','کافه در حالت حذف و غیرفعال قرارگرفت.');
        return redirect()->route('companies.index');



    }

    public function de_active(string $id)
    {
        if (!Company::where('id', $id)->exists()) {
            session()->flash('status','error');
            session()->flash('message','کافه پیدا نشد .');
            return redirect()->route('companies.index');
        }
        $company = Company::where('id', $id)->first();
        if ($company->active == 0) {
            session()->flash('status','error');
            session()->flash('message','کافه فعال است .');
            return redirect()->route('companies.index');
        }
        $company->active = 0;
        $company->save();
        session()->flash('status','success');
        session()->flash('message','کافه با موفقیت غیر فعال شد .');
        return redirect()->route('companies.index');
    }

    public function active(string $id)
    {
        if (!Company::where('id', $id)->exists()) {
            session()->flash('status','error');
            session()->flash('message','کافه پیدا نشد .');
            return redirect()->route('companies.index');
        }
        $company = Company::where('id', $id)->first();
        if ($company->active == 1) {
            session()->flash('status','error');
            session()->flash('message','کافه فعال است .');
            return redirect()->route('companies.index');
        }

        $company->active = 1;
        $company->save();
        session()->flash('status','success');
        session()->flash('message','کافه با موفقیت فعال شد .');
        return redirect()->route('companies.index');
    }

}
