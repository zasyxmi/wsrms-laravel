<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\RepairRequest;
use App\Models\SparePart;
use Illuminate\Contracts\View\View;

class ReportController extends Controller
{
    public function index(): View
    {
        $repairStatusCounts = [
            'submitted' => RepairRequest::where('status', 'submitted')->count(),
            'approved' => RepairRequest::where('status', 'approved')->count(),
            'assigned' => RepairRequest::where('status', 'assigned')->count(),
            'under_diagnosis' => RepairRequest::where('status', 'under_diagnosis')->count(),
            'in_repair' => RepairRequest::where('status', 'in_repair')->count(),
            'waiting_for_parts' => RepairRequest::where('status', 'waiting_for_parts')->count(),
            'repair_completed' => RepairRequest::where('status', 'repair_completed')->count(),
            'waiting_payment' => RepairRequest::where('status', 'waiting_payment')->count(),
            'paid' => RepairRequest::where('status', 'paid')->count(),
            'ready_for_pickup' => RepairRequest::where('status', 'ready_for_pickup')->count(),
            'completed' => RepairRequest::where('status', 'completed')->count(),
            'rejected' => RepairRequest::where('status', 'rejected')->count(),
            'unable_to_repair' => RepairRequest::where('status', 'unable_to_repair')->count(),
        ];

        $invoiceSummary = [
            'total_invoices' => Invoice::count(),
            'paid_invoices' => Invoice::where('status', 'paid')->count(),
            'unpaid_invoices' => Invoice::where('status', 'unpaid')->count(),
            'total_invoice_amount' => Invoice::sum('total_amount'),
        ];

        $paymentSummary = [
            'total_payments' => Payment::count(),
            'successful_payments' => Payment::where('status', 'paid')->count(),
            'total_amount_received' => Payment::where('status', 'paid')->sum('amount_paid'),
        ];

        $lowStockParts = SparePart::query()
            ->where('stock_quantity', '<=', 5)
            ->orderBy('stock_quantity')
            ->get();

        $recentPayments = Payment::query()
            ->with(['customer.user', 'invoice.repairRequest'])
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.reports.index', compact(
            'repairStatusCounts',
            'invoiceSummary',
            'paymentSummary',
            'lowStockParts',
            'recentPayments'
        ));
    }
}