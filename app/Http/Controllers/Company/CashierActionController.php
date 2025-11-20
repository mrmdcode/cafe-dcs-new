<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CashierActionController extends Controller
{
    public function dashboard()
    {
        return view('dashboard.company.cashier.dashboard');
    }


}
