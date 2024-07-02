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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->uniqid();
            $table->date('order_date')->default(now());
            $table->decimal('total_price', 15, 2)->default(0);
            $table->enum('status', ['not_paid', 'paid', 'not_sent', 'sent','done'])->default('not_paid');
            $table->foreignId('vendor_id')->references('id')->on('vendors')->onDelete('cascade');
            $table->foreignId('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
