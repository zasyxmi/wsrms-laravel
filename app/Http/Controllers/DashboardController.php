<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Device;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\RepairRequest;
use App\Models\SparePart;
use App\Models\Technician;
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

            return view('admin.dashboard', compact('summary', 'recentRepairRequests'));
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

            return view('customer.dashboard', compact('summary', 'latestRepairRequests'));
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