<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;

class APIServiceMenuController extends Controller
{
    public function ln($company)
    {
        $company = Company::where('username', $company)->with(['template_data','work_shifts'])->firstOrFail();
        if ($company->active){
            if ($company->plan_menu){
                return response()->json(compact('company'));
            }
            else{
                return response()->json(['error'=>"dont have menu service"],402);
            }
        }
        else{
            return response()->json(['error'=>"company not active"],404);
        }
    }
    public function menus($company)
    {
        $company = Company::where('username', $company)->with(['template_data','work_shifts'])->firstOrFail();
        $menus = $company->Menu()->where('show_customer',1)->with(['MenuItem'=>function ($item) {
            $item->where('show_customer',1);
        }])->get();
        if ($company->active){
            if ($company->plan_menu){
                return response()->json(compact('menus','company'));
            }
            else{
                return response()->json(['error'=>"dont have menu service"],402);
            }
        }
        else{
            return response()->json(['error'=>"company not active"],404);
        }
    }
}
