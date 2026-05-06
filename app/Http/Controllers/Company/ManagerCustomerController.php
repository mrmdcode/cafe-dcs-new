<?php
namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ManagerCustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::latest()
            ->with('orders')
            ->orderBy('name', 'DESC')
            ->get();

        return view('dashboard.company.manager.customer', compact('customers'));
    }

    /**
     * Return customer data for the edit modal.
     */
    public function edit(Customer $customer): JsonResponse
    {
        return response()->json([
            'customer' => $customer->only(['id', 'name', 'phone', 'address']),
        ]);
    }

    /**
     * Update the customer's details.
     */
    public function update(Request $request, Customer $customer): JsonResponse
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'phone'   => 'required|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

        $customer->update($validated);

        return response()->json([
            'status'   => 'success',
            'message'  => 'اطلاعات مشتری با موفقیت به‌روزرسانی شد.',
            'customer' => $customer->fresh()->only('id', 'name', 'phone', 'address'),
        ]);
    }

    /**
     * Return the customer with their orders for the orders model
     */
    public function orders(Customer $customer): JsonResponse
    {
        $customer->load([
            'orders' => function ($query) {
                $query->latest()->with(['menu_item' => function ($q) {
                    # Qualify columns to avoid ambiguity
                    $q->select('menu_items.id', 'menu_items.price');
                }]);
            },
        ]);

        $orders = $customer->orders->map(function ($order) {
            $total = $order->menu_item->sum(function ($item) {
                return $item->pivot->qty * $item->price;
            });

            return [
                'id'         => $order->id,
                'key'        => $order->unique_key,
                'total'      => number_format($total, 0, '.', ''),
                'created_at' => $order->created_at->format('Y-m-d H:i:s'),
            ];
        });

        return response()->json([
            'customer' => $customer->only('id', 'name'),
            'orders'   => $orders,
        ]);
    }

}
