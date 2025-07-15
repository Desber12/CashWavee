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
        $table->unsignedBigInteger('order_id')->constrained('order')->onDelete('cascade');
        $table->unsignedBigInteger('produk_id')->constrained('produk')->onDelete('cascade');
        $table->integer('jumlah');
        
        $table->decimal('subtotal', 12, 2);
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
