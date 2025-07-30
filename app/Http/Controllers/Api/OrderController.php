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
    $payload = request()->all();

         $orders = \App\Models\Order::query();
        
        if(!empty($payload['order'])){
            $orders->where('order','LIKE','%'.$payload['order'].'%');
        }

        if(!empty($payload['id'])){
            $orders->where('id', $payload['id']);
        }

        if(!empty($payload['kasir_id'])){
            $orders->where('kasir_id', $payload['kasir_id']);
        }

        if (!empty($payload['start_date']) && !empty($payload['end_date'])) {
        $orders->whereBetween('created_at', [
            $payload['start_date'] . ' 00:00:00',
            $payload['end_date'] . ' 23:59:59'
        ]);
        } elseif (!empty($payload['created_at'])) {
        $orders->whereDate('created_at', $payload['created_at']);
        }
                    
        if(!empty($payload['order_sort']) && !empty($payload['order_by'])){
            $orders->orderBy($payload['order_by'], $payload['order_sort']);
        }

        $perPage = !empty($payload['per_page']) ? (int)$payload['per_page'] : 10;

        $orders = $orders->paginate($perPage);
        
    return response()->json([
        'success' => true,
        'message' => 'List of Orders',
        'data' => $orders
    ], 200);

    if ($orders->isEmpty()) {
        return response()->json([
            'success' => false,
            'message' => 'Not Found',
            'data' => []
        ], 404);
    }

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
