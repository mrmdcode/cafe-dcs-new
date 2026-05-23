<?php
namespace App\Http\Controllers;

use App\Models\Company;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = \auth()->user();
        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }
        if (! Company::where('id', $user->company_id)->first()->active) {
            return abort(403, "پنل فعال نیست .شارژ کنید .");
        } else {
            if (! $user->hasRole('admin') && $user->company_id != null && $user->position == "manager") {
                return redirect()->route('company.manager.dashboard');
            }
            if (! $user->hasRole('admin') && $user->company_id != null && $user->position == "cashier") {
                return redirect()->route('company.cashier.dashboard');
            }
            if (! $user->hasRole('admin') && $user->company_id != null && $user->position == "order_recipient") {
                return redirect()->route('company.order_recipient.dashboard');
            }
        }
        return abort(404);
    }
}
