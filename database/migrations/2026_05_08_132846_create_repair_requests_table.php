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
    Schema::create('repair_requests', function (Blueprint $table): void {
        $table->id();
        $table->string('repair_code')->unique();
        $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
        $table->foreignId('device_id')->constrained()->cascadeOnDelete();
        $table->foreignId('technician_id')->nullable()->constrained()->nullOnDelete();

        $table->text('issue_description');
        $table->text('diagnosis_result')->nullable();
        $table->text('repair_notes')->nullable();

        $table->string('preferred_contact_method')->nullable();
        $table->string('status')->default('submitted');

        $table->date('request_date');
        $table->date('completed_date')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('repair_requests');
    }
};
