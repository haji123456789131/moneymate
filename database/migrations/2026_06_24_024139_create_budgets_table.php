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
       Schema::create('budgets', function (Blueprint $table) {
    $table->id(); // bigint, PK
    $table->foreignId('user_id')->constrained()->onDelete('cascade'); // bigint, FK
    $table->foreignId('category_id')->constrained()->onDelete('cascade'); // bigint, FK
    $table->decimal('limit_amount', 15, 2); // decimal
    $table->integer('month'); // int
    $table->integer('year'); // int
    $table->timestamps();
    
    // Mencegah duplikasi anggaran untuk kategori yang sama di bulan & tahun yang sama
    $table->unique(['user_id', 'category_id', 'month', 'year']);
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budgets');
    }
};
