<?php
namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;

class CashierActionController extends Controller
{
    public function dashboard()
    {
        return view('dashboard.company.cashier.dashboard');
    }
}
