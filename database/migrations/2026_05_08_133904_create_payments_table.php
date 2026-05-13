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
    Schema::create('payments', function (Blueprint $table): void {
        $table->id();
        $table->string('payment_number')->unique();
        $table->foreignId('invoice_id')->constrained()->cascadeOnDelete();
        $table->foreignId('customer_id')->constrained()->cascadeOnDelete();

        $table->decimal('amount_paid', 10, 2);
        $table->string('payment_method')->default('online');
        $table->string('transaction_reference')->nullable();
        $table->string('status')->default('pending');

        $table->string('receipt_number')->nullable()->unique();
        $table->timestamp('paid_at')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
