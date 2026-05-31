<?php
namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Jobs\SendMessageCreateUserJob;
use App\Models\User;
use Faker\Factory as Faker;
use function Laravel\Prompts\password;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ManagerEmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = User::where('company_id', auth()->user()->company_id)
            ->whereNot('position', 'manager')->whereNot('work_status', 'dismissal')->get();
        return view('dashboard.company.manager.employee', compact('employees'));
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
        $faker    = Faker::create();
        $password = $faker->password(8);
        $email = auth()->user()->company->username . rand(10, 99) . $request->input('position') . "@gmail.com";
//        return $password;

        $user = User::create([
            'name'           => $request->input('name'),
            'email'          => $email,
            'password'       => Hash::make($password),
            'family'         => $request->input('family'),
            'age'            => $request->input('age'), # No validation error for age
            'state'          => $request->input('state'),
            'address'        => $request->input('address'),
            'city'           => $request->input('city'),
            'company_id'     => auth()->user()->company_id,
            'phone_number'   => $request->input('phone_number'),
            'national_id'    => $request->input('national_id'),
            'telegram_phone' => $request->input('telegram_phone'),
            'telegram_id'    => $request->input('telegram_id'),
            'static_ip'      => $request->input('static_ip'),
            'work_status'    => $request->input('work_status'),
            'position'       => $request->input('position'),
        ]);
        // TODO send SMS for send notification
        dispatch(new SendMessageCreateUserJob($user->name, $email, $password, $user->phone_number));
        session()->flash('status', 'success');
        session()->flash('message', $user->name . ' با موفقیت به پرسنل اضافه شد .');
        return redirect()->route('company.employee.index');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $employee = User::where('id', $id)->first();
        if (is_null($employee)) {
            session()->flash('status', 'error');
            session()->flash('message', 'پرسنل وجود ندارد به پشتیبانی اطلاع دهید .');
            return redirect()->route('company.employee.index');
        }
        if ($employee->company_id != auth()->user()->company_id) {
            session()->flash('status', 'error');
            session()->flash('message', 'در سیستم خطا به وجود آمده ، به پشتیبانی اطلاع دهید .');
            return redirect()->route('company.employee.index');
        }
        return response()->json(compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

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
        //
    }

    public function de_suspension($employee)
    {
        $employee = User::where('id', $employee)->first();
        if (is_null($employee)) {
            session()->flash('status', 'error');
            session()->flash('message', 'پرسنل وجود ندارد به پشتیبانی اطلاع دهید .');
            return redirect()->route('company.employee.index');
        }
        if ($employee->company_id != auth()->user()->company_id) {
            session()->flash('status', 'error');
            session()->flash('message', 'در سیستم خطا به وجود آمده ، به پشتیبانی اطلاع دهید .');
            return redirect()->route('company.employee.index');
        }
        $employee->work_status = 'contract';
        $employee->save();
        session()->flash('status', 'success');
        session()->flash('message', 'کاربر از حالت معلق درآمد .');
        return redirect()->route('company.employee.index');
    }
    public function dismissal($employee)
    {
        $employee = User::where('id', $employee)->first();
        if (is_null($employee)) {
            session()->flash('status', 'error');
            session()->flash('message', 'پرسنل وجود ندارد به پشتیبانی اطلاع دهید .');
            return redirect()->route('company.employee.index');
        }
        if ($employee->company_id != auth()->user()->company_id) {
            session()->flash('status', 'error');
            session()->flash('message', 'در سیستم خطا به وجود آمده ، به پشتیبانی اطلاع دهید .');
            return redirect()->route('company.employee.index');
        }
        $employee->work_status = 'dismissal';
        $employee->save();
        session()->flash('status', 'success');
        session()->flash('message', 'کاربر اخراج شد .');
        return redirect()->route('company.employee.index');
    }
    public function suspension($employee)
    {
        $employee = User::where('id', $employee)->first();
        if (is_null($employee)) {
            session()->flash('status', 'error');
            session()->flash('message', 'پرسنل وجود ندارد به پشتیبانی اطلاع دهید .');
            return redirect()->route('company.employee.index');
        }
        if ($employee->company_id != auth()->user()->company_id) {
            session()->flash('status', 'error');
            session()->flash('message', 'در سیستم خطا به وجود آمده ، به پشتیبانی اطلاع دهید .');
            return redirect()->route('company.employee.index');
        }
        $employee->work_status = 'suspension';
        $employee->save();
        session()->flash('status', 'success');
        session()->flash('message', 'کاربر به حالت معلق درآمد .');
        return redirect()->route('company.employee.index');
    }
}
