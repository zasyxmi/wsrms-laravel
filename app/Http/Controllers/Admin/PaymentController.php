<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Contracts\View\View;

class PaymentController extends Controller
{
    public function index(): View
    {
        $payments = Payment::query()
            ->with([
                'customer.user',
                'invoice.repairRequest.device',
            ])
            ->latest()
            ->paginate(10);

        return view('admin.payments.index', compact('payments'));
    }

    public function show(Payment $payment): View
    {
        $payment->load([
            'customer.user',
            'invoice.repairRequest.device',
            'invoice.repairRequest.technician.user',
            'invoice.repairRequest.repairSpareParts.sparePart',
        ]);

        return view('admin.payments.show', compact('payment'));
    }
}
