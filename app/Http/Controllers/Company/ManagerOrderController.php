<?php
namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManagerOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.company.manager.orders');
    }

    /**
     * Fetch orders based on date filters.
     */
    public function indexData(Request $request)
    {
        $companyId = Auth::user()->company_id;
        $query     = Order::withTrashed()
            ->where('company_id', $companyId)
            ->with(['table', 'customer', 'order_recipient', 'menu_item' => function ($q) {
                $q->withTrashed();
            }]);

        if ($request->input('today')) {
            $query->where('created_at', '>', Carbon::today());
        } elseif ($request->input('yesterday')) {
            $query->whereBetween('created_at', [Carbon::yesterday(), Carbon::today()]);
        } elseif ($request->input('older')) {
            $query->where('created_at', '<', Carbon::yesterday());
        }

        $data = $query->get();

        if ($request->input('paid')) {
            $data = $data->filter(function ($order) {
                return ! in_array($order->status, ['registration', 'cancelled', 'edit']);
            })->values();
        }

        return response()->json($data);
    }

    public function init_modal()
    {
        $company = Company::where('id', auth()->user()->company_id)->first();
        $menus   = $company->Menu()->with('MenuItem')->get();
        return response()->json(compact('menus'));
    }
    /**
     * Get tables and menus for the admin order modal.
     */
    public function getTablesAndMenus()
    {
        $companyId = Auth::user()->company_id;
        $company   = Company::find($companyId);

        // Get all menus with their items
        $menus = $company->Menu()
            ->with('MenuItem')
            ->get()
            ->map(function ($menu) {
                return [
                    'id'        => $menu->id,
                    'name'      => $menu->name,
                    'menu_item' => $menu->MenuItem,
                ];
            });

        // Get all tables, and attach the most recent incomplete order (registration or edit) created within last 2 hours
        $tables = $company->Table()->with(['orders' => function ($query) {
            $query->where(function ($q) {
                $q->where('status', 'registration')
                    ->orWhere('status', 'edit');
            })
                ->where('created_at', '>', Carbon::now()->subHours(2))
                ->orderByDesc('created_at');
        }])->get();

        // Keep only the first (most recent) matching order per table
        $tables->each(function ($table) {
            $table->orders = $table->orders->first();
        });

        return response()->json(compact('tables', 'menus'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, string $unique_key)
    {
        $data = Order::withTrashed()
            ->where('id', $id)
            ->where('unique_key', $unique_key)
            ->where('company_id', auth()->user()->company_id)
            ->with(['table', 'customer', 'order_recipient', 'menu_item' => function ($query) {
                $query->withTrashed();
            }])->firstOrFail();

        return response()->json($data);
    }

    public function edit(string $id, string $unique_key)
    {
        return $this->show($id, $unique_key);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    public function paidding(string $id, string $unique_key)
    {
        $order = Order::where('id', $id)->where('unique_key', $unique_key)->first();
        if ($order->status == 'paid') {
            return response()->json('Order is already paid', 409);
        }
        $order->status = 'paid';
        $order->save();
        return response()->json('', 200);
    }

    public function finishing(string $id, string $unique_key)
    {
        $order = Order::where('id', $id)->where('unique_key', $unique_key)->first();
        if ($order->status == 'paid') {
            return response()->json('Order is already paid', 409);
        }
        if ($order->status == 'finish') {
            return response()->json('Order is already finish', 409);
        }
        $order->status = 'finish';
        $order->save();
        return response()->json('', 200);
    }

    public function showFactor(string $id, string $unique_key)
    {
        $order = Order::withTrashed()
            ->where('id', $id)
            ->where('unique_key', $unique_key)
            ->where('company_id', auth()->user()->company_id)
            ->with(['table', 'customer', 'order_recipient', 'menu_item' => function ($query) {
                $query->withTrashed();
            }])
            ->firstOrFail();

        $company  = auth()->user()->company;
        $items    = [];
        $subtotal = 0;
        foreach ($order->menu_item as $item) {
            $qty       = $item->pivot->qty;
            $price     = $item->pivot->per; // unit price
            $total     = $qty * $price;
            $subtotal += $total;
            $items[]   = [
                'name'        => $item->name,
                'qty'         => $qty,
                'price'       => $price,
                'total'       => $total,
                'description' => $item->pivot->description,
            ];
        }

        $discount   = $order->discount ?? 0;
        $grandTotal = $subtotal - $discount;

        return view('dashboard.company.manager.factor', compact('order', 'company', 'items', 'subtotal', 'discount', 'grandTotal'));
    }
}
