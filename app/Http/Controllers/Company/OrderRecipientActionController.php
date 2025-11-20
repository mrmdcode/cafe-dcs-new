<?php

namespace App\Http\Controllers\Company;

use App\Events\order_registration;
use App\Http\Controllers\Controller;
use App\Jobs\SendMessageOrderRegistarad;
use App\Models\Company;

use App\Models\Customer;
use App\Models\MenuItem;
use App\Models\Order;
use App\Models\Table;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Http\Request;
//use Validator;

class OrderRecipientActionController extends Controller
{
    public function dashboard()
    {
        $company = auth()->user()->company;
        $user = auth()->user();
        return view('dashboard.company.order_recipient.dashboard',compact('company','user'));
    }
    public function indexData()
    {

        $companyId = auth()->user()->company_id;
        $company = Company::find($companyId);

        // دریافت منوها و آیتم‌های منو
        $menus = $company->Menu()->with('MenuItem')->get();
//        TODO just available and show bool

        // دریافت جدول‌ها و سفارش‌ها با شرط ۲ ساعت پیش
        $tables = $company->Table()->with(['orders' => function ($query) {
            $query
                ->orderByDesc('created_at')
                ->where('created_at', '>', Carbon::now()->subHours(2))
                ->where('status', 'registration')
                ->orWhere('status', 'edit');

               ; // مستقیماً اولین سفارش را دریافت می‌کنیم
        }])->get();
        // تغییر orders به اولین سفارش به جای استفاده از unset
        $tables->each(function ($table) {
            $table->orders = $table->orders->first(); // در صورتی که first() را قبلاً صدا زده باشیم نیازی به unset نیست
        });
        return response(compact('tables', 'company', 'menus'));
    }
    public function store(Request $req)
    {
            $validatedData = $req->validate([
                'customer_phone' => ['min:10','max:12'],
                'subscription_code_value' => ['integer'],
                'customer_name' => [ 'required', 'max:255','min:3'],
            ],[
                'customer_phone.required' => "شماره تلفن الزامیست .",
                'customer_phone.min' => "شماره تلفن را درست وارد کنید.",
                'customer_phone.max' => "شماره تلفن را درست وارد کنید.",
                'customer_name.required' => " نام مشتری الزامیست .",
                'customer_name.min' => "حداقل طول نام مشتری 3 کارکتر است .",
                'customer_name.max' => "حداکثر طول نام مشتری 255 کارکتر است .",
            ]);

        try {

            $faker = Faker::create();
            $unique_key ='';
            for ($i = 1; $i <= rand(5,10); $i++) {
                $unique_key = $unique_key.$faker->randomLetter();

            }

            $company = Company::where('id',auth()->user()->company_id)->first();
            $customer = Customer::where('phone',$req->input('customer_phone'))->first();
            if (!$customer){
                $customer = Customer::create([
                    'name'=>$req->input('customer_name'),
                    'phone'=>$req->input('customer_phone'),
                ]);
            }
            $order = Order::create([
                'unique_key'=>$unique_key,
                'table_id' => $req->input('tableSelected'),
                'company_id' => $company->id,
                'customer_id' => $customer->id,
                'order_recipient_id'=>auth()->user()->id,
            ]);
            foreach ($req->input('ordersItem') as $items){
                $order->menu_item()->attach($items['id'], ['qty'=>$items['qty'],'description'=>$items['description'],'per' => MenuItem::find($items['id'])->price]);
            }
            if ($company->plan_order_taker){
                event(new order_registration($company->username,Order::where('id',$order->id)->with(['menu_item','customer','Table'])->first(),$company->plan_printer_control));
            }
            if ($customer->phone && $company->plan_preparation_notification){
               dispatch(new SendMessageOrderRegistarad($company->name,$customer->phone,$company->username,$order->id.'-'.$order->unique_key));
            }
            return response(['message'=>'سفارش با موفقیت ثبت شد.'],201);
        }
        catch (\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function edit($id)
    {
        $table = Table::where('id',$id)->where('company_id',auth()->user()->company_id)->firstOrFail();

        if (!$table) {
            return response()->json(['message' => 'Table not found'], 404);
        }

        // دریافت آخرین سفارش مرتبط با میز
        $order = $table->orders()->orderByDesc('created_at')->with(['customer','menu_item'])->first();

        if (!$order) {
            return response()->json(['message' => 'No orders found for this table'], 404);
        }

        // واکشی آیتم‌های منو مرتبط با آخرین سفارش


        // بازگرداندن داده‌ها به صورت JSON
        return response()->json($order, 202);

    }

    public function update(Request $req, $id,$unique_key)
    {
        try {

            // یافتن سفارش بر اساس شناسه
            $order = Order::where('id', $id)->where('unique_key',$unique_key)->first();

            if (!$order) {
                return response()->json(['message' => 'Order not found'], 404);
            }

            // به‌روزرسانی اطلاعات سفارش
//            $order->customer_name = $req->input('customer_name');
//            $order->customer_phone = $req->input('customer_phone');
            $order->status= 'edit';
            $order->update();

            // آماده‌سازی داده‌ها برای sync
            $syncData = [];
            foreach ($req->input('ordersItem') as $item) {
                $syncData[$item['id']] = ['qty' => $item['qty'],'description'=>$item['description'],'per' => MenuItem::find($item['id'])->price];
            }

            // به‌روزرسانی آیتم‌های منوی مرتبط با استفاده از sync
            $order->menu_item()->sync($syncData);

            return response(['message'=>'سفارش با موفقیت بروزرسانی شد.']);
        } catch (Exception $e) {
            // ارسال خطا به کلاینت
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function subscription_code(Request $request)
    {
        $request->validate([
            'subscription_code_value' => ['required','integer','max:120000','exists:customers,id'],
        ],[
            'subscription_code_value.required' => 'کد اشتراک خالیست .',
            'subscription_code_value.integer' => 'کد اشتراک عدد است.',
            'subscription_code_value.exists' => 'مشتری با این کد اشتراک وجود ندارد.',
            'subscription_code_value.max' => 'طول کد اشتراک مشتری بیشتر از حد مجاز هست.',
        ]);
        $customer =Customer::findOrFail($request->input('subscription_code_value'))->first();
        return response()->json(['name'=>$customer->name]);
    }
}
