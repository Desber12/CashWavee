<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\Produk;
use App\Models\OrderItem;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::all();
        $orders = Order::with('user')->get();
        return view('order.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();       
        $produks = Produk::all();
        return view('order.create', compact('users', 'produks'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'produk_id' => 'required|array',
            'produk_id.*' => 'exists:produks,id',
            'quantity' => 'required|array',
            'quantity.*' => 'integer|min:1',
        ]);

        $order = Order::create([
            'user_id' => $request->user_id,
            'total_harga' => 0, // akan dihitung nanti
            'status' => 'pending',
        ]);

        $totalHarga = 0;

        foreach ($request->produk_id as $index => $produkId) {
            $produk = Produk::findOrFail($produkId);
            $quantity = $request->quantity[$index];
            $subtotal = $produk->harga * $quantity;

            OrderItem::create([
                'order_id' => $order->id,
                'produk_id' => $produkId,
                'quantity' => $quantity,
                'harga_satuan' => $produk->harga,
                'subtotal' => $subtotal * $quantity,
            ]);

            $totalHarga += $subtotal;
        }

        $order->update(['total_harga' => $totalHarga]);

        return redirect()->route('orders.index')->with('success', 'Order berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
