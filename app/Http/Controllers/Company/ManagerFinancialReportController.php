<?php
namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManagerFinancialReportController extends Controller
{
    public function index(Request $request)
    {
        $companyID = Auth::user()->company_id;

        $query = Order::where('company_id', $companyID)
            ->where('status', 'paid')
            ->with(['customer:id,name', 'menu_item' => function ($q) {
                $q->select('menu_items.id', 'menu_items.price');
            }]);

        $total      = 0;
        $orders     = collect();
        $reportType = $request->get('type', 'today');

        if ($reportType === 'today') {
            $query->whereDate('orders.created_at', today());
        } else if ($reportType === 'daily' && $request->filled('date')) {
            $query->whereDate('orders.created_at', $request->date);
        } elseif ($reportType === 'monthly' && $request->filled('month')) {
            $month             = $request->month; // format: YYYY-MM
            [$year, $monthNum] = explode('-', $month);
            $query->whereYear('orders.created_at', $year)
                ->whereMonth('orders.created_at', $monthNum);
        } elseif ($reportType === 'custom' && $request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('orders.created_at', [$request->start_date, $request->end_date]);
        }

        $orders = $query->with(['menu_item' => function ($q) {
            $q->select('menu_items.id', 'menu_items.price' , 'menu_items.name');
        }])
            ->orderBy('orders.created_at', 'desc')
            ->get();

        // Calculate total revenue
        $total = $orders->sum(function ($order) {
            return $order->menu_item->sum(function ($item) {
                return $item->pivot->qty * $item->price;
            });
        });

        return view('dashboard.company.manager.financial', compact('orders', 'total', 'reportType'));
    }
}
