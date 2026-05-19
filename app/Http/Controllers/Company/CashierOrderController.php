<?php
namespace App\Http\Controllers\Company;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Order;
use App\Models\Table;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;

class CashierOrderController extends Controller
{
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

        return view('dashboard.company.cashier.orders.index', [
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

        return view('dashboard.company.cashier.orders.edit', compact('order', 'menus', 'tables'));
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
}
