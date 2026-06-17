<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('payments', 'gateway')) {
            Schema::table('payments', function (Blueprint $table): void {
                $table->string('gateway')->nullable()->after('status');
            });
        }

        if (! Schema::hasColumn('payments', 'gateway_reference')) {
            Schema::table('payments', function (Blueprint $table): void {
                $table->string('gateway_reference')->nullable()->after('gateway');
            });
        }

        if (! Schema::hasColumn('payments', 'gateway_bill_code')) {
            Schema::table('payments', function (Blueprint $table): void {
                $table->string('gateway_bill_code')->nullable()->after('gateway_reference');
            });
        }

        if (! Schema::hasColumn('payments', 'gateway_status')) {
            Schema::table('payments', function (Blueprint $table): void {
                $table->string('gateway_status')->nullable()->after('gateway_bill_code');
            });
        }

        if (! Schema::hasColumn('payments', 'paid_at')) {
            Schema::table('payments', function (Blueprint $table): void {
                $table->timestamp('paid_at')->nullable()->after('receipt_number');
            });
        }
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table): void {
            if (Schema::hasColumn('payments', 'gateway_status')) {
                $table->dropColumn('gateway_status');
            }

            if (Schema::hasColumn('payments', 'gateway_bill_code')) {
                $table->dropColumn('gateway_bill_code');
            }

            if (Schema::hasColumn('payments', 'gateway_reference')) {
                $table->dropColumn('gateway_reference');
            }

            if (Schema::hasColumn('payments', 'gateway')) {
                $table->dropColumn('gateway');
            }
        });
    }
};
