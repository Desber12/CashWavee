<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    use HasFactory;
       protected $table = 'order_produk';
    protected $fillable =
    [
        'order_id',
        'produk_id',
        'product_id',
        'quantity',
        'total_price'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class,);
    }

    public function product()
    {
        return $this->belongsTo(Product::class,'produk_id');
    }
    public function orderProducts()
    {   
    return $this->hasMany(OrderProduct::class);
    }

}
