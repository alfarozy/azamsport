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
        Schema::create('rental_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->integer('quantity')->default(1);
            $table->string('rental_name');
            $table->string('rental_phone');
            $table->string('rental_address')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('delivery_option', ['pickup', 'delivery']);
            $table->string('delivery_address')->nullable();
            $table->text('notes')->nullable();
            $table->bigInteger('total_price')->default(0);
            $table->enum('status', ['pending', 'confirmed', 'cancelled', 'returned'])->default('pending');
            $table->enum('payment_status', ['unpaid', 'paid'])->default('unpaid');
            $table->string('payment_method')->nullable();
            $table->string('payment_proof')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rental_orders');
    }
};
