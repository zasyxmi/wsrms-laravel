<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\PayInvoiceRequest;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\SystemNotification;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Mail\PickupReadyMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class PaymentController extends Controller
{
    public function pay(PayInvoiceRequest $request, Invoice $invoice): RedirectResponse
    {
        $customer = Auth::user()->customer;

        abort_if($invoice->customer_id !== $customer->id, 403, 'Unauthorized access.');

        if ($invoice->status === 'paid') {
            return redirect()
                ->route('customer.invoices.show', $invoice)
                ->with('error', 'This invoice has already been paid.');
        }

        $payment = null;

        DB::transaction(function () use ($invoice, &$payment): void {
            $payment = Payment::create([
                'payment_number' => $this->generatePaymentNumber(),
                'invoice_id' => $invoice->id,
                'customer_id' => $invoice->customer_id,
                'amount_paid' => $invoice->total_amount,
                'payment_method' => 'simulation',
                'transaction_reference' => 'SIM-' . now()->format('YmdHis') . '-' . $invoice->id,
                'status' => 'paid',
                'receipt_number' => $this->generateReceiptNumber(),
                'paid_at' => now(),
            ]);

            $invoice->update([
                'status' => 'paid',
            ]);

            SystemNotification::create([
                'user_id' => $invoice->customer->user_id,
                'title' => 'Payment Successful',
                'message' => 'Your payment for invoice ' . $invoice->invoice_number . ' has been completed successfully.',
                'type' => 'success',
            ]);

            SystemNotification::create([
                'user_id' => $invoice->customer->user_id,
                'title' => 'Device Ready for Pickup',
                'message' => 'Your repaired device for repair request ' . $invoice->repairRequest->repair_code . ' is ready for pickup.',
                'type' => 'success',
            ]);

            $admins = User::query()
                ->where('role', 'admin')
                ->get();

            foreach ($admins as $admin) {
                SystemNotification::create([
                    'user_id' => $admin->id,
                    'title' => 'Payment Received',
                    'message' => 'Payment ' . $payment->payment_number . ' has been received for invoice ' . $invoice->invoice_number . '.',
                    'type' => 'success',
                ]);
            }
        });

        if ($payment) {
            try {
                Mail::to($payment->customer->user->email)
                    ->send(new PickupReadyMail($payment));
            } catch (Throwable $exception) {
                Log::warning('Pickup ready email failed to send.', [
                    'payment_id' => $payment->id,
                    'error' => $exception->getMessage(),
                ]);
            }
        }

        return redirect()
            ->route('customer.invoices.show', $invoice)
            ->with('success', 'Payment has been completed successfully. A pickup notification has been sent.');
    }

    private function generatePaymentNumber(): string
    {
        $latestPayment = Payment::query()->latest('id')->first();
        $nextNumber = $latestPayment ? $latestPayment->id + 1 : 1;

        return 'PAY' . str_pad((string) $nextNumber, 3, '0', STR_PAD_LEFT);
    }

    private function generateReceiptNumber(): string
    {
        $latestPayment = Payment::query()->latest('id')->first();
        $nextNumber = $latestPayment ? $latestPayment->id + 1 : 1;

        return 'RCPT' . str_pad((string) $nextNumber, 3, '0', STR_PAD_LEFT);
    }
}