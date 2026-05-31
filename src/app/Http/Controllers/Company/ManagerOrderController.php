<?php
namespace App\Http\Controllers\Company;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Customer;
use App\Models\MenuItem;
use App\Models\Order;
use App\Models\Table;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Enum;

class ManagerOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        $company = Company::query()
            ->with([
                'Menu.MenuItem',
                'Table.orders' => function ($query) {
                    $query->whereIn('status', ['registration', 'edit'])
                        ->where('created_at', '>', now()->subHours(2))
                        ->latest();
                },
            ])
            ->findOrFail($user->company_id);

        $orders = Order::query()
            ->withTrashed()
            ->with([
                'table',
                'customer',
                'order_recipient',
                'menu_item' => fn($query) => $query->withTrashed(),
            ])
            ->where('company_id', $user->company_id)

        // Search filters
            ->searchCustomer($request->customer_name)
            ->searchLocation($request->location)
            ->searchInvoice($request->invoice)

        // Date filters
            ->when(
                $request->filled('date_from') || $request->filled('date_to'),
                function ($query) use ($request) {
                    $query->dateFrom($request->date_from)
                        ->dateTo($request->date_to);
                },
                function ($query) use ($request) {
                    $query
                        ->when($request->filled('today'), fn($q) => $q->today())
                        ->when($request->filled('yesterday'), fn($q) => $q->yesterday())
                        ->when($request->filled('older'), fn($q) => $q->older());
                }
            )

        // Status filters
            ->when($request->filled('paid'), fn($query) => $query->statusPaid())

            ->latest()
            ->paginate(50);

        $menus = $company->Menu->map(fn($menu) => [
            'id'        => $menu->id,
            'name'      => $menu->name,
            'menu_item' => $menu->MenuItem,
        ]);

        $tables = $company->Table->map(function ($table) {
            $table->setRelation(
                'orders',
                $table->orders->first()
            );

            return $table;
        });

        return view('dashboard.company.manager.orders.index', [
            'orders' => $orders,
            'tables' => $tables,
            'menus'  => $menus,
        ]);
    }

    /**
     * Show order details for the view modal (JSON).
     */
    public function show(Order $order): JsonResponse
    {
        $order->load(['table', 'customer', 'order_recipient', 'menu_item' => fn($q) => $q->withTrashed()]);

        return response()->json($order);
    }

    /**
     * Show order data for the edit modal (JSON).
     * You can reuse the same structure as show, or add extra data (e.g. menus).
     */
    public function edit(Order $order)
    {
        // Load relationships needed for the form
        $order->loadMissing([
            'customer',
            'table',
            'menu_item' => fn($q) => $q->withTrashed(),
        ]);

        $company = Company::with('Menu.MenuItem')->findOrFail(auth()->user()->company_id);
        $menus   = $company->Menu;
        $tables  = Table::all();

        return view('dashboard.company.manager.orders.edit', compact('order', 'menus', 'tables'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'customer_name'  => 'nullable|string|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'table_id'       => 'nullable|exists:tables,id',
            'items'          => 'required|array',
            'items.*.id'     => 'required|exists:menu_items,id',
            'items.*.qty'    => 'required|integer|min:1', // cart only sends positive qtys
            'items.*.desc'   => 'nullable|string|max:255',
        ]);

        $companyId = Auth::user()->company_id;

        if (empty($request->items)) {
            return redirect()->back()->with('error', 'حداقل یک آیتم باید انتخاب شود.');
        }

        $customer = null;
        if ($request->filled('customer_name') || $request->filled('customer_phone')) {
            $customer = Customer::updateOrCreate(
                [
                    'phone' => $request->customer_phone,
                ],
                [
                    'name' => $request->customer_name,
                ]
            );
        }

        $order = Order::create([
            'company_id'         => $companyId,
            'customer_id'        => $customer?->id,
            'table_id'           => $request->table_id,
            'order_recipient_id' => Auth::id(),
            'status'             => 'registration',
            'unique_key'         => Order::generateUniqueKey(),
            'created_at'         => Carbon::now(),
            'updated_at'         => Carbon::now(),
            // Do not set waiter_id, cashier, discount, waiter_time, cashier_time here
        ]);

        foreach ($request->items as $item) {
            $menuItem = MenuItem::find($item['id']);
            $order->menu_item()->attach($item['id'], [
                'qty'         => $item['qty'],
                'per'         => $menuItem->price, // store current price
                'description' => $item['desc'] ?? null,
            ]);
        }

        return redirect()->route('company.order.index')->with('success', 'سفارش با موفقیت ثبت شد.');
    }

    /**
     * Update the order status (paid / finish).
     * Expects a 'status' field in the request body.
     */
    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'customer_name'       => 'nullable|string|max:255',
            'customer_phone'      => 'nullable|string|max:255',
            'table_id'            => 'nullable|exists:tables,id',
            'items'               => 'nullable|array',
            'items.*.id'          => 'required|integer|exists:menu_items,id',
            'items.*.qty'         => 'required|integer|min:1',
            'items.*.description' => 'nullable|string|max:1000',
        ]);

        // update customer
        if ($order->customer) {
            $order->customer->update([
                'name'  => $validated['customer_name'] ?? null,
                'phone' => $validated['customer_phone'] ?? null,
            ]);
        }

        // update order
        $order->update([
            'table_id' => $validated['table_id'] ?? null,
        ]);

        // sync items
        $syncData = [];

        foreach ($validated['items'] ?? [] as $item) {
            $syncData[$item['id']] = [
                'qty'         => $item['qty'],
                'description' => $item['description'] ?? '',
            ];
        }

        $order->menu_item()->sync($syncData);

        return redirect()
            ->route('company.cashier.orders.index')
            ->with('success', 'سفارش بروزرسانی شد');
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => ['required', new Enum(OrderStatus::class)],
        ]);

        $order->update([
            'status' => $validated['status'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'وضعیت سفارش بروزرسانی شد',
            'status'  => $order->status,
        ]);
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
