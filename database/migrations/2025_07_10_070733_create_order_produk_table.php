<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_produk', function (Blueprint $table) {
            $table->id();
            //order id
            $table->foreignId('order_id')->constrained('order');
            //product id
            $table->foreignId('produk_id')->constrained('produk');
            //quantity
            $table->integer('quantity');
            //total price
            $table->integer('total_price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_produk');
    }
};
