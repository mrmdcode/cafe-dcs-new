<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminActionController extends Controller
{
    public function dashboard()
    {
        return view('dashboard.admin.dashboard');
    }

}
