<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreInvoiceRequest;
use App\Models\Invoice;
use App\Models\RepairRequest;
use App\Models\SystemNotification;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function index(): View
    {
        $invoices = Invoice::query()
            ->with([
                'customer.user',
                'repairRequest.device',
                'payment',
            ])
            ->latest()
            ->paginate(10);

        return view('admin.invoices.index', compact('invoices'));
    }

    public function show(Invoice $invoice): View
    {
        $invoice->load([
            'customer.user',
            'repairRequest.device',
            'repairRequest.technician.user',
            'repairRequest.repairSpareParts.sparePart',
            'payment',
        ]);

        return view('admin.invoices.show', compact('invoice'));
    }

    public function create(RepairRequest $repairRequest): View|RedirectResponse
    {
        $repairRequest->load([
            'customer.user',
            'device',
            'technician.user',
            'repairSpareParts.sparePart',
            'invoice',
        ]);

        if ($repairRequest->status !== 'completed') {
            return redirect()
                ->route('admin.repair-requests.show', $repairRequest)
                ->with('error', 'Invoice can only be generated after the repair is completed.');
        }

        if ($repairRequest->invoice) {
            return redirect()
                ->route('admin.repair-requests.show', $repairRequest)
                ->with('error', 'Invoice has already been generated for this repair request.');
        }

        $sparePartTotal = $repairRequest->repairSpareParts->sum('subtotal');

        return view('admin.invoices.create', compact('repairRequest', 'sparePartTotal'));
    }

    public function store(StoreInvoiceRequest $request, RepairRequest $repairRequest): RedirectResponse
    {
        $repairRequest->load([
            'customer.user',
            'repairSpareParts',
            'invoice',
        ]);

        if ($repairRequest->status !== 'completed') {
            return redirect()
                ->route('admin.repair-requests.show', $repairRequest)
                ->with('error', 'Invoice can only be generated after the repair is completed.');
        }

        if ($repairRequest->invoice) {
            return redirect()
                ->route('admin.repair-requests.show', $repairRequest)
                ->with('error', 'Invoice has already been generated for this repair request.');
        }

        DB::transaction(function () use ($request, $repairRequest): void {
            $sparePartTotal = $repairRequest->repairSpareParts->sum('subtotal');

            $totalAmount =
                $request->diagnosis_fee +
                $request->service_charge +
                $sparePartTotal +
                $request->additional_charge;

            $invoice = Invoice::create([
                'invoice_number' => $this->generateInvoiceNumber(),
                'repair_request_id' => $repairRequest->id,
                'customer_id' => $repairRequest->customer_id,
                'diagnosis_fee' => $request->diagnosis_fee,
                'service_charge' => $request->service_charge,
                'spare_part_total' => $sparePartTotal,
                'additional_charge' => $request->additional_charge,
                'total_amount' => $totalAmount,
                'status' => 'unpaid',
                'generated_at' => now(),
            ]);

            SystemNotification::create([
                'user_id' => $repairRequest->customer->user_id,
                'title' => 'Invoice Generated',
                'message' => 'Invoice ' . $invoice->invoice_number . ' has been generated for repair request ' . $repairRequest->repair_code . '.',
                'type' => 'info',
            ]);
        });

        return redirect()
            ->route('admin.repair-requests.show', $repairRequest)
            ->with('success', 'Invoice has been generated successfully.');
    }

    private function generateInvoiceNumber(): string
    {
        $latestInvoice = Invoice::query()->latest('id')->first();
        $nextNumber = $latestInvoice ? $latestInvoice->id + 1 : 1;

        return 'INV' . str_pad((string) $nextNumber, 3, '0', STR_PAD_LEFT);
    }
}