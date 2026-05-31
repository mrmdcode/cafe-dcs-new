<?php
namespace App\Http\Controllers\API\Company;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    public function show(Order $order): JsonResponse
    {
        $order->load(['table', 'customer', 'order_recipient', 'menu_item' => fn($q) => $q->withTrashed()]);

        return response()->json($order);
    }

    public function paying(Order $order): JsonResponse
    {
        if ($order->status === OrderStatus::Paid) {
            return response()->json('این سفارش قبلاً تسویه شده است.', 422);
        }

        $order->update(['status' => OrderStatus::Paid]);

        return response()->json(['message' => 'تسویه با موفقیت انجام شد.']);
    }

    public function finish(Order $order): JsonResponse
    {
        if (in_array($order->status, [OrderStatus::Finish, OrderStatus::Paid])) {
            return response()->json('این سفارش قبلاً به اتمام رسیده است.', 422);
        }

        $order->update(['status' => OrderStatus::Finish]);

        return response()->json(['message' => 'سفارش با موفقیت به اتمام رسید.']);
    }
}
