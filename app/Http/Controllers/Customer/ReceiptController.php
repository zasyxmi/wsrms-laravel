<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ReceiptController extends Controller
{
    public function show(Payment $payment): View
    {
        $customer = Auth::user()->customer;

        abort_if($payment->customer_id !== $customer->id, 403, 'Unauthorized access.');

        $payment->load([
            'invoice.repairRequest.device',
            'invoice.repairRequest.repairSpareParts.sparePart',
            'customer.user',
        ]);

        return view('customer.receipts.show', compact('payment'));
    }

    public function download(Payment $payment): Response
    {
        $customer = Auth::user()->customer;

        abort_if($payment->customer_id !== $customer->id, 403, 'Unauthorized access.');

        $payment->load([
            'invoice.repairRequest.device',
            'invoice.repairRequest.repairSpareParts.sparePart',
            'customer.user',
        ]);

        $pdf = Pdf::loadView('customer.receipts.pdf', compact('payment'));

        return $pdf->download($payment->receipt_number . '.pdf');
    }
}