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
        $query = Order::withTrashed()
            ->with([
                'table',
                'customer',
                'order_recipient',
                'menu_item' => fn($q) => $q->withTrashed(),
            ])
            ->where('company_id', auth()->user()->company_id);

        // --- Search fields ---
        $query->searchCustomer($request->input('customer_name'));
        $query->searchLocation($request->input('location'));
        $query->searchInvoice($request->input('invoice'));

        // --- Date filters ---
        $dateFrom = $request->input('date_from');
        $dateTo   = $request->input('date_to');

        if ($dateFrom || $dateTo) {
            // Custom range: use date_from/date_to regardless of the preset buttons
            $query->dateFrom($dateFrom)
                ->dateTo($dateTo);
        } else {
            // No custom range – apply time presets
            if ($request->filled('today')) {
                $query->today();
            } elseif ($request->filled('yesterday')) {
                $query->yesterday();
            } elseif ($request->filled('older')) {
                $query->older();
            }
        }

        // --- Paid / finished switch ---
        if ($request->filled('paid')) {
            $query->statusPaid();
        }

        $orders = $query->get();
        return view('dashboard.company.cashier.orders', compact('orders'));
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

        return view('dashboard.company.cashier.orders-edit', compact('order', 'menus', 'tables'));
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
