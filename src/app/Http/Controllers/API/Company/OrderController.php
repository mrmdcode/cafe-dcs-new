<?php
namespace App\Http\Controllers\API\Company;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function show(Order $order): JsonResponse
    {
        $this->authorizeCompany($order);

        $order->load(['table', 'customer', 'order_recipient', 'menu_item' => fn($q) => $q->withTrashed()]);

        return response()->json($order);
    }

    public function paying(Order $order): JsonResponse
    {
        $this->authorizeCompany($order);

        if ($order->status === OrderStatus::Paid) {
            return response()->json('این سفارش قبلاً تسویه شده است.', 422);
        }

        $order->update(['status' => OrderStatus::Paid]);

        return response()->json(['message' => 'تسویه با موفقیت انجام شد.']);
    }

    public function finish(Order $order): JsonResponse
    {
        $this->authorizeCompany($order);

        if (in_array($order->status, [OrderStatus::Finish, OrderStatus::Paid])) {
            return response()->json('این سفارش قبلاً به اتمام رسیده است.', 422);
        }

        $order->update(['status' => OrderStatus::Finish]);

        return response()->json(['message' => 'سفارش با موفقیت به اتمام رسید.']);
    }

    public function cancel(Request $request, Order $order): JsonResponse
    {
        $this->authorizeCompany($order);

        if ($order->status === OrderStatus::Paid) {
            return response()->json('سفارش تسویه‌شده قابل لغو نیست.', 422);
        }

        $order->update([
            'status'             => OrderStatus::Cancelled,
            'delete_description' => $request->input('reason'),
        ]);
        $order->delete();

        return response()->json(['message' => 'سفارش لغو شد.']);
    }

    private function authorizeCompany(Order $order): void
    {
        abort_if($order->company_id !== auth()->user()->company_id, 403);
    }
}
