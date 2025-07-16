<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class order_produk extends Model
{
    use HasFactory;

        protected $table = 'order_produk';

    protected $fillable =
    [
        'order_id',
        'produk_id',
        'quantity',
        'total_price'
    ];

    public function order()
    {
        return $this->belongsTo(order::class, 'order_id', 'id');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id', 'id');
    }
}
