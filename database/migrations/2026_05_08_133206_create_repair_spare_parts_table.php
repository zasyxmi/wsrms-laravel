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
    Schema::create('repair_spare_parts', function (Blueprint $table): void {
        $table->id();
        $table->foreignId('repair_request_id')->constrained()->cascadeOnDelete();
        $table->foreignId('spare_part_id')->constrained()->cascadeOnDelete();
        $table->integer('quantity_used');
        $table->decimal('unit_price', 10, 2);
        $table->decimal('subtotal', 10, 2);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('repair_spare_parts');
    }
};
