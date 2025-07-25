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
        Schema::table('products', function (Blueprint $table) {
            // tambahkan kolom category_id dan buat foreign key ke tabel categories
            $table->foreignId('category_id')->constrained('categories')->after('stock');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // hapus foreign key dan kolomnya jika rollback
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
        });
    }
};
