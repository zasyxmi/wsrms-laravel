<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    public function show(Invoice $invoice): View
    {
        $customer = Auth::user()->customer;

        abort_if($invoice->customer_id !== $customer->id, 403, 'Unauthorized access.');

        $invoice->load([
            'repairRequest.device',
            'repairRequest.repairSpareParts.sparePart',
            'payment',
        ]);

        return view('customer.invoices.show', compact('invoice'));
    }
}