<?php

namespace App\Http\Controllers\Company;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use App\Support\Jalali;
use Illuminate\Support\Facades\DB;

class ManagerActionController extends Controller
{
    public function dashboard()
    {
        $companyId = auth()->user()->company_id;

        $ordersQuery = fn () => Order::where('company_id', $companyId);

        $paidOrders = $ordersQuery()->where('status', OrderStatus::Paid)
            ->with('menu_item')
            ->get();

        $totalSales = $paidOrders->sum(function (Order $order) {
            return $order->menu_item->sum(fn ($item) => $item->pivot->per * $item->pivot->qty) - (int) $order->discount;
        });

        $totalOrders = $ordersQuery()->count();
        $totalCustomers = Customer::whereHas('Orders', fn ($q) => $q->where('company_id', $companyId))->count();

        $topItemsToday = DB::table('item_order')
            ->join('orders', 'orders.id', '=', 'item_order.order_id')
            ->join('menu_items', 'menu_items.id', '=', 'item_order.menu_item_id')
            ->where('orders.company_id', $companyId)
            ->whereDate('orders.created_at', today())
            ->whereNull('orders.deleted_at')
            ->selectRaw('menu_items.name, SUM(item_order.qty) as total_qty')
            ->groupBy('menu_items.id', 'menu_items.name')
            ->orderByDesc('total_qty')
            ->limit(5)
            ->get();

        $todayOrders = $ordersQuery()->whereDate('created_at', today())->get();
        $todayStatusCounts = $todayOrders->countBy(fn (Order $order) => $order->status->value);
        $todayTotal = max($todayOrders->count(), 1);
        $statusBreakdown = collect(OrderStatus::cases())->map(function (OrderStatus $status) use ($todayStatusCounts, $todayTotal) {
            $count = $todayStatusCounts->get($status->value, 0);
            return [
                'label' => $status->label(),
                'color' => $status->color(),
                'count' => $count,
                'percent' => round(($count / $todayTotal) * 100),
            ];
        });

        $recentCustomers = Customer::withCount(['Orders' => fn ($q) => $q->where('company_id', $companyId)])
            ->whereHas('Orders', fn ($q) => $q->where('company_id', $companyId))
            ->latest()
            ->limit(5)
            ->get();

        $recentOrders = $ordersQuery()
            ->with(['customer', 'table', 'menu_item'])
            ->latest()
            ->limit(5)
            ->get()
            ->map(function (Order $order) {
                return [
                    'id' => $order->id,
                    'customer' => $order->customer->name ?? ($order->table->name ?? '—'),
                    'total' => $order->menu_item->sum(fn ($item) => $item->pivot->per * $item->pivot->qty) - (int) $order->discount,
                    'date' => Jalali::toJalali($order->created_at),
                    'status' => $order->status,
                ];
            });

        return view('dashboard.company.manager.dashboard', [
            'totalSales' => $totalSales,
            'totalOrders' => $totalOrders,
            'totalCustomers' => $totalCustomers,
            'topItemsToday' => $topItemsToday,
            'statusBreakdown' => $statusBreakdown,
            'recentCustomers' => $recentCustomers,
            'recentOrders' => $recentOrders,
        ]);
    }
}
