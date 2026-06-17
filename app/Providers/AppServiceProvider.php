<?php

namespace App\Providers;

use App\Models\Invoice;
use App\Models\RepairRequest;
use App\Models\SparePart;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('layouts.navigation', function ($view): void {
            $badgeCounts = [
                'adminRepairRequestsBadgeCount' => 0,
                'adminInvoicesBadgeCount' => 0,
                'adminPaymentsBadgeCount' => 0,
                'adminSparePartsBadgeCount' => 0,
            ];

            $user = auth()->user();

            if ($user?->role === 'admin') {
                $badgeCounts = [
                    'adminRepairRequestsBadgeCount' => RepairRequest::query()
                        ->where('status', 'submitted')
                        ->count(),
                    'adminInvoicesBadgeCount' => RepairRequest::query()
                        ->where('status', 'completed')
                        ->doesntHave('invoice')
                        ->count(),
                    'adminPaymentsBadgeCount' => Invoice::query()
                        ->where('status', 'unpaid')
                        ->count(),
                    'adminSparePartsBadgeCount' => SparePart::query()
                        ->where('stock_quantity', '<=', 5)
                        ->count(),
                ];
            }

            $view->with($badgeCounts);
        });
    }
}
