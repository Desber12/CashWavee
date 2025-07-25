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
        $totalPrice = 0;
        $orderProducts = [];

        //Cek stok dulu
        foreach ($validated['order_produk'] as $item) {
            $product = Product::find($item['produk_id']);

            if (!$product) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Produk tidak ditemukan.',
                    'produk_id' => $item['produk_id']
                ], 404);
            }

            if ($item['quantity'] > $product->stock) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Stok produk tidak mencukupi',
                    'produk_id' => $product->id,
                    'requested_quantity' => $item['quantity'],
                    'available_stock' => $product->stock,
                ], 400);
            }

            $totalPrice = $totalPrice + ($item['quantity'] * $product->price);
        }

        //Buat order
        $order = Order::create([
            'kasir_id' => $validated['user_id'],
            'total_price' => $totalPrice,
            'total_item' => count($validated['order_produk']),
            'payment_method' => $request->payment_method ?? 'cash',
        ]);

        //Tambahkan detail order dan kurangi stok
        foreach ($validated['order_produk'] as $item) {
            $product = Product::find($item['produk_id']);
            $subtotal = $product->price * $item['quantity'];
            $totalPrice += $subtotal;

            $order->orderProducts()->create([
                'produk_id' => $item['produk_id'],
                'quantity' => $item['quantity'],
                'total_price' => $item['quantity'] * $product->price,
                'subtotal' => $subtotal
            ]);

            //Kurangi stok produk
            $product->decrement('stock', $item['quantity']);

            $orderProducts[] = [
                'produk_id' => $product->id,
                'quantity' => $item['quantity'],
                'price' => $item['quantity'] * $product->price,
                'subtotal' => $subtotal
            ];
        }


        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Order berhasil dibuat',
            'data' => [
                'order_id' => $order->id,
                'user_id' => $order->kasir_id,
                "quantity" => $order->total_item,
                'total_price' => $order->total_price,
                'order_products' => $orderProducts,
                'created_at' => $order->created_at->toDateTimeString()
            ]
        ], 201);
    } catch (\Exception $e) {
        DB::rollBack();

        return response()->json([
            'success' => false,
            'message' => 'Gagal membuat order',
            'error' => $e->getMessage()
        ], 500);
    }
}


}
