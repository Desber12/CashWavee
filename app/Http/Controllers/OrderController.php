<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    //index
    public function index()
    {
        $order = \App\Models\Order::with('kasir')->orderBy('created_at', 'desc')->paginate(10);

        return view('order.index', compact('order'));

    }

    //view
    public function show($id)
    {
        $order = \App\Models\Order::with('kasir')->findOrFail($id);

        //get order items by order id
        $orderProducts = \App\Models\OrderProduct::with('product')->where('order_id', $id)->get();


        return view('order.view', compact('order', 'orderProducts'));
    }
    
}
