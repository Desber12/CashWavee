<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable =
    [
        'transaction_time',
        'total_price',
        'total_item',
        'kasir_id',
        'payment_method'
    ];

    public function kasir()
    {
        return $this->belongsTo(User::class, 'kasir_id', 'id');
    }

    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class);
    }
    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_produk', 'order_id', 'produk_id')
                    ->withPivot('quantity', 'created_at', 'updated_at')
                    ->withTimestamps();
    }
}
