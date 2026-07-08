<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Device;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\RepairRequest;
use App\Models\SparePart;
use App\Models\Technician;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(): View|RedirectResponse
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            $summary = [
                'total_customers' => Customer::count(),
                'total_technicians' => Technician::count(),
                'total_devices' => Device::count(),
                'pending_repairs' => RepairRequest::whereIn('status', [
                    'submitted',
                    'approved',
                    'assigned',
                    'under_diagnosis',
                    'in_repair',
                    'waiting_for_parts',
                ])->count(),
                'completed_repairs' => RepairRequest::where('status', 'completed')->count(),
                'unpaid_invoices' => Invoice::where('status', 'unpaid')->count(),
                'total_payments' => Payment::where('status', 'paid')->sum('amount_paid'),
                'low_stock_parts' => SparePart::where('stock_quantity', '<=', 5)->count(),
            ];

            $recentRepairRequests = RepairRequest::query()
                ->with(['customer.user', 'device', 'technician.user'])
                ->latest()
                ->limit(5)
                ->get();

            $now = Carbon::now();
            $startOfMonth = $now->copy()->startOfMonth();
            $endOfMonth = $now->copy()->endOfMonth();

            $monthlySalesLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            $monthlySalesData = array_fill(0, 12, 0);
            $monthlyPaymentCounts = array_fill(0, 12, 0);

            $monthlyPayments = Payment::query()
                ->selectRaw('MONTH(paid_at) as month, SUM(amount_paid) as total_sales, COUNT(*) as payment_count')
                ->where('status', 'paid')
                ->whereYear('paid_at', $now->year)
                ->groupByRaw('MONTH(paid_at)')
                ->get();

            foreach ($monthlyPayments as $monthlyPayment) {
                $monthIndex = (int) $monthlyPayment->month - 1;

                if ($monthIndex >= 0 && $monthIndex < 12) {
                    $monthlySalesData[$monthIndex] = (float) $monthlyPayment->total_sales;
                    $monthlyPaymentCounts[$monthIndex] = (int) $monthlyPayment->payment_count;
                }
            }

            $salesAnalytics = [
                'sales_this_month' => Payment::where('status', 'paid')
                    ->whereBetween('paid_at', [$startOfMonth, $endOfMonth])
                    ->sum('amount_paid'),
                'sales_this_year' => Payment::where('status', 'paid')
                    ->whereYear('paid_at', $now->year)
                    ->sum('amount_paid'),
                'completed_repairs_this_month' => RepairRequest::where('status', 'completed')
                    ->whereBetween('completed_date', [$startOfMonth->toDateString(), $endOfMonth->toDateString()])
                    ->count(),
                'paid_invoices_this_month' => Invoice::where('status', 'paid')
                    ->whereHas('payment', function ($query) use ($startOfMonth, $endOfMonth): void {
                        $query->where('status', 'paid')
                            ->whereBetween('paid_at', [$startOfMonth, $endOfMonth]);
                    })
                    ->count(),
                'unpaid_invoices' => Invoice::where('status', 'unpaid')->count(),
            ];

            return view('admin.dashboard', compact(
                'summary',
                'recentRepairRequests',
                'monthlySalesLabels',
                'monthlySalesData',
                'monthlyPaymentCounts',
                'salesAnalytics'
            ));
        }

        if ($user->role === 'customer') {
            $customer = $user->customer;

            if (! $customer) {
                return view('customer.dashboard', [
                    'summary' => [
                        'total_repair_requests' => 0,
                        'pending_repairs' => 0,
                        'completed_repairs' => 0,
                        'unpaid_invoices' => 0,
                        'paid_invoices' => 0,
                    ],
                    'latestRepairRequests' => collect(),
                    'currentRepairRequest' => null,
                ]);
            }

            $summary = [
                'total_repair_requests' => RepairRequest::where('customer_id', $customer->id)->count(),
                'pending_repairs' => RepairRequest::where('customer_id', $customer->id)
                    ->whereIn('status', [
                        'submitted',
                        'approved',
                        'assigned',
                        'under_diagnosis',
                        'in_repair',
                        'waiting_for_parts',
                    ])
                    ->count(),
                'completed_repairs' => RepairRequest::where('customer_id', $customer->id)
                    ->where('status', 'completed')
                    ->count(),
                'unpaid_invoices' => Invoice::where('customer_id', $customer->id)
                    ->where('status', 'unpaid')
                    ->count(),
                'paid_invoices' => Invoice::where('customer_id', $customer->id)
                    ->where('status', 'paid')
                    ->count(),
            ];

            $latestRepairRequests = RepairRequest::query()
                ->with(['device', 'technician.user', 'invoice'])
                ->where('customer_id', $customer->id)
                ->latest()
                ->limit(5)
                ->get();

            $currentRepairRequest = RepairRequest::query()
                ->with(['device', 'technician.user', 'invoice.payment'])
                ->where('customer_id', $customer->id)
                ->whereNotIn('status', ['rejected', 'unable_to_repair'])
                ->latest()
                ->first();

            return view('customer.dashboard', compact('summary', 'latestRepairRequests', 'currentRepairRequest'));
        }

        if ($user->role === 'technician') {
            $technician = $user->technician;

            if (! $technician) {
                return view('technician.dashboard', [
                    'summary' => [
                        'total_assigned_tasks' => 0,
                        'new_assigned_tasks' => 0,
                        'under_diagnosis_tasks' => 0,
                        'in_repair_tasks' => 0,
                        'waiting_for_parts_tasks' => 0,
                        'completed_tasks' => 0,
                    ],
                    'latestAssignedTasks' => collect(),
                ]);
            }

            $summary = [
                'total_assigned_tasks' => RepairRequest::where('technician_id', $technician->id)->count(),
                'new_assigned_tasks' => RepairRequest::where('technician_id', $technician->id)
                    ->where('status', 'assigned')
                    ->count(),
                'under_diagnosis_tasks' => RepairRequest::where('technician_id', $technician->id)
                    ->where('status', 'under_diagnosis')
                    ->count(),
                'in_repair_tasks' => RepairRequest::where('technician_id', $technician->id)
                    ->where('status', 'in_repair')
                    ->count(),
                'waiting_for_parts_tasks' => RepairRequest::where('technician_id', $technician->id)
                    ->where('status', 'waiting_for_parts')
                    ->count(),
                'completed_tasks' => RepairRequest::where('technician_id', $technician->id)
                    ->where('status', 'completed')
                    ->count(),
            ];

            $latestAssignedTasks = RepairRequest::query()
                ->with(['customer.user', 'device', 'invoice'])
                ->where('technician_id', $technician->id)
                ->latest()
                ->limit(5)
                ->get();

            return view('technician.dashboard', compact('summary', 'latestAssignedTasks'));
        }

        return redirect()->route('login');
    }
}
