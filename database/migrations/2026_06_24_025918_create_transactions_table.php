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
      Schema::create('transactions', function (Blueprint $table) {
    $table->id(); // bigint, PK
    $table->foreignId('user_id')->constrained()->onDelete('cascade'); // bigint, FK
    $table->foreignId('category_id')->constrained()->onDelete('cascade'); // bigint, FK
    $table->decimal('amount', 15, 2); // decimal
    $table->string('type'); // string
    $table->text('description')->nullable(); // text
    $table->dateTime('transaction_date'); // datetime
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
