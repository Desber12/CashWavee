<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderProduk; // gunakan model order_produk yang sudah kamu buat
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Mail\OrderShipped;
use App\Models\User;
use Resend\Laravel\Facades\Resend;

class ReportController extends Controller
{
    public function summary(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'start_date' => 'required|date_format:Y-m-d',
            'end_date'   => 'required|date_format:Y-m-d|after_or_equal:start_date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => $validator->errors()
            ], 422);
        }

        $start_date = Carbon::parse($request->start_date)->startOfDay();
        $end_date   = Carbon::parse($request->end_date)->endOfDay();

        // total revenue dari tabel orders
        $orders       = Order::whereBetween('created_at', [$start_date, $end_date])->get();
        $totalRevenue = $orders->sum('total_price');

        // total quantity dari tabel order_produk
        $totalSoldQuantity = DB::table('order_produk')
            ->join('orders', 'order_produk.order_id', '=', 'orders.id')
            ->whereBetween('orders.created_at', [$start_date, $end_date])
            ->sum('order_produk.jumlah');

        return response()->json([
            'status' => 'success',
            'data'   => [
                'total_revenue'      => $totalRevenue,
                'total_sold_quantity'=> $totalSoldQuantity,
            ]
        ]);
    }

    public function productSales(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'start_date' => 'required|date_format:Y-m-d',
            'end_date'   => 'required|date_format:Y-m-d|after_or_equal:start_date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => $validator->errors()
            ], 422);
        }

        $start_date = Carbon::parse($request->start_date)->startOfDay();
        $end_date   = Carbon::parse($request->end_date)->endOfDay();

        $query = DB::table('order_produk')
            ->select(
                'products.id as product_id',
                'products.name as product_name',
                'products.price as product_price',
                DB::raw('SUM(order_produk.jumlah) as total_quantity'),
                DB::raw('SUM(order_produk.subtotal) as total_price')
            )
            ->join('products', 'order_produk.produk_id', '=', 'products.id')
            ->whereBetween(DB::raw('DATE(order_produk.created_at)'), [$start_date, $end_date])
            ->groupBy('products.id', 'products.name', 'products.price')
            ->orderBy('total_quantity', 'desc');

        $totalProductSold = $query->get();

        return response()->json([
            'status' => 'success',
            'data'   => $totalProductSold
        ]);
    }

    public function closeCashier(Request $request)
    {
        $start_date = date('Y-m-d 00:00:00');
        $end_date   = date('Y-m-d 23:59:59');

        $orders       = Order::whereBetween('created_at', [$start_date, $end_date])->get();
        $totalRevenue = $orders->sum('total_price');

        $totalSoldQuantity = DB::table('order_produk')
            ->join('orders', 'order_produk.order_id', '=', 'orders.id')
            ->whereBetween('orders.created_at', [$start_date, $end_date])
            ->sum('order_produk.jumlah');

        $dataReport = [
            'total_revenue'      => $totalRevenue,
            'total_sold_quantity'=> $totalSoldQuantity
        ];

        $query2 = DB::table('order_produk')
            ->select(
                'products.id as product_id',
                'products.name as product_name',
                'products.price as product_price',
                DB::raw('SUM(order_produk.jumlah) as total_quantity'),
                DB::raw('SUM(order_produk.subtotal) as total_price')
            )
            ->join('products', 'order_produk.produk_id', '=', 'products.id')
            ->whereBetween(DB::raw('DATE(order_produk.created_at)'), [$start_date, $end_date])
            ->groupBy('products.id', 'products.name', 'products.price')
            ->orderBy('total_quantity', 'desc');

        $totalProductSold = $query2->get();

        $owner = User::where('roles', 'admin')->first();

        Resend::emails()->send([
            'from'    => 'CashWave <sandyae1140@gmail.com>',
            'to'      => [$owner->email],
            'subject' => 'Report Harian - ' . now()->format('Y-m-d'),
            'html'    => (new OrderShipped($dataReport, $totalProductSold))->render(),
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Data laporan berhasil dikirim',
        ]);
    }
}
