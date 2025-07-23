<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderProduct;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
    $orders = Order::with('products')->orderBy('created_at', 'desc')->get();

    return response()->json([
        'success' => true,
        'message' => 'List of Orders',
        'data' => $orders
    ], 200);
    }

    public function show($id)
    {
        $order = Order::findOrFail($id);
        return response()->json($order);
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->update($request->all());
        return response()->json($order);
    }

    public function destroy($id)
    {
        Order::destroy($id);
        return response()->json(null, 204);
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'user_id' => 'required|exists:users,id',
        'order_produk' => 'required|array|min:1',
        'order_produk.*.produk_id' => 'required|exists:products,id',
        'order_produk.*.quantity' => 'required|integer|min:1',
    ]);

    DB::beginTransaction();

    try {
        $order = Order::create([
            'kasir_id' => $validated['user_id'],
            'total_price' => 0,
            'total_item' => count($validated['order_produk']),
            'payment_method' => $request->payment_method ?? 'cash',
        ]);

        $order->refresh(); // agar data terbaru dimuat dari database

        $totalPrice = 0;
        $orderProducts = [];

        foreach ($validated['order_produk'] as $item) {
            $product = Product::find($item['produk_id']);
            $subtotal = $product->price * $item['quantity'];
            $totalPrice += $subtotal;

            $order->orderProducts()->create([
                'produk_id' => $item['produk_id'],
                'quantity' => $item['quantity'],
                'price' => $product->price,
                'subtotal' => $subtotal
            ]);

            $orderProducts[] = [
                'produk_id' => $product->id,
                'quantity' => $item['quantity'],
                'price' => $product->price,
                'subtotal' => $subtotal
            ];
        }

        $order->update(['total_price' => $totalPrice]);

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Order created successfully',
            'data' => [
                'order_id' => $order->id,
                'user_id' => $order->kasir_id,
                "quantity" => $order->total_item,
                'total_price' => $order->total_price,
                'order_products' => $orderProducts,
                'created_at' => $order->created_at->toDateTimeString()
            ]
        ]);
    } catch (\Exception $e) {
        DB::rollBack();

        return response()->json([
            'success' => false,
            'message' => 'Failed to create order',
            'error' => $e->getMessage()
        ], 500);
    }
}

}
