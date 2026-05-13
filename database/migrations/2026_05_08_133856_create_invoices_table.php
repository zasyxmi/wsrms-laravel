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
    Schema::create('invoices', function (Blueprint $table): void {
        $table->id();
        $table->string('invoice_number')->unique();
        $table->foreignId('repair_request_id')->constrained()->cascadeOnDelete();
        $table->foreignId('customer_id')->constrained()->cascadeOnDelete();

        $table->decimal('diagnosis_fee', 10, 2)->default(0);
        $table->decimal('service_charge', 10, 2)->default(0);
        $table->decimal('spare_part_total', 10, 2)->default(0);
        $table->decimal('additional_charge', 10, 2)->default(0);
        $table->decimal('total_amount', 10, 2)->default(0);

        $table->string('status')->default('unpaid');
        $table->timestamp('generated_at')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
