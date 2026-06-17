<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\PayInvoiceRequest;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\SystemNotification;
use App\Models\User;
use App\Services\ToyyibPayService;
use App\Mail\PickupReadyMail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
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

        $payment = Payment::create([
            'payment_number' => $this->generatePaymentNumber(),
            'invoice_id' => $invoice->id,
            'customer_id' => $invoice->customer_id,
            'amount_paid' => $invoice->total_amount,
            'payment_method' => 'simulation',
            'transaction_reference' => 'SIM-' . now()->format('YmdHis') . '-' . $invoice->id,
            'status' => 'pending',
        ]);

        $this->completePayment($payment, $payment->transaction_reference);

        return redirect()
            ->route('customer.invoices.show', $invoice)
            ->with('success', 'Payment has been completed successfully. A pickup notification has been sent.');
    }

    public function payWithToyyibPay(Invoice $invoice, ToyyibPayService $toyyibPay): RedirectResponse
    {
        $customer = Auth::user()->customer;

        abort_if($invoice->customer_id !== $customer->id, 403, 'Unauthorized access.');

        if ($invoice->status === 'paid') {
            return redirect()
                ->route('customer.invoices.show', $invoice)
                ->with('error', 'This invoice has already been paid.');
        }

        try {
            $bill = $toyyibPay->createBill($invoice);

            $payment = Payment::query()
                ->where('invoice_id', $invoice->id)
                ->where('gateway', 'toyyibpay')
                ->where('status', '!=', 'paid')
                ->latest('id')
                ->first();

            if (! $payment) {
                $payment = new Payment([
                    'payment_number' => $this->generatePaymentNumber(),
                    'invoice_id' => $invoice->id,
                    'customer_id' => $invoice->customer_id,
                ]);
            }

            $payment->fill([
                'amount_paid' => $invoice->total_amount,
                'payment_method' => 'ToyyibPay FPX Sandbox',
                'transaction_reference' => $bill['external_reference'],
                'status' => 'pending',
                'gateway' => 'toyyibpay',
                'gateway_reference' => $bill['external_reference'],
                'gateway_bill_code' => $bill['bill_code'],
                'gateway_status' => 'pending',
            ]);
            $payment->save();

            return redirect()->away($bill['payment_url']);
        } catch (Throwable $exception) {
            return redirect()
                ->route('customer.invoices.show', $invoice)
                ->with('error', 'ToyyibPay payment could not be started. ' . $exception->getMessage());
        }
    }

    public function toyyibpayReturn(Request $request): RedirectResponse
    {
        $statusId = (string) $request->query('status_id');
        $billCode = (string) $request->query('billcode');
        $orderId = (string) $request->query('order_id');

        $payment = Payment::query()
            ->where('gateway_bill_code', $billCode)
            ->first();

        if (! $payment) {
            return redirect()
                ->route('dashboard')
                ->with('error', 'ToyyibPay payment record was not found.');
        }

        if ($statusId === '1') {
            $this->completePayment($payment, $orderId ?: null);

            if (Auth::check() && Auth::user()->customer?->id === $payment->customer_id) {
                return redirect()
                    ->route('customer.receipts.show', $payment)
                    ->with('success', 'ToyyibPay payment has been completed successfully.');
            }

            return redirect()
                ->route('dashboard')
                ->with('success', 'ToyyibPay payment has been completed successfully.');
        }

        if ($statusId === '2') {
            $payment->update([
                'gateway_status' => 'pending',
            ]);

            return redirect()
                ->route('customer.invoices.show', $payment->invoice)
                ->with('success', 'ToyyibPay payment is still pending.');
        }

        if ($statusId === '3') {
            $payment->update([
                'gateway_status' => 'failed',
                'status' => $payment->status === 'paid' ? 'paid' : 'failed',
            ]);

            return redirect()
                ->route('customer.invoices.show', $payment->invoice)
                ->with('error', 'ToyyibPay payment failed or was cancelled.');
        }

        return redirect()
            ->route('customer.invoices.show', $payment->invoice)
            ->with('error', 'ToyyibPay returned an unknown payment status.');
    }

    public function toyyibpayCallback(Request $request, ToyyibPayService $toyyibPay): Response
    {
        $payload = $request->all();

        if (! $toyyibPay->verifyCallbackHash($payload)) {
            return response('Invalid hash', 403);
        }

        if (empty($payload['billcode']) && empty($payload['order_id'])) {
            return response('Payment not found', 404);
        }

        $payment = Payment::query()
            ->where(function ($query) use ($payload): void {
                if (! empty($payload['billcode'])) {
                    $query->where('gateway_bill_code', $payload['billcode']);
                }

                if (! empty($payload['order_id'])) {
                    $query->orWhere('gateway_reference', $payload['order_id']);
                }
            })
            ->first();

        if (! $payment) {
            return response('Payment not found', 404);
        }

        $status = (string) ($payload['status'] ?? '');

        if ($status === '1') {
            $this->completePayment($payment, $payload['refno'] ?? null);
        } elseif ($status === '2') {
            $payment->update([
                'gateway_status' => 'pending',
            ]);
        } elseif ($status === '3') {
            $payment->update([
                'gateway_status' => 'failed',
                'status' => $payment->status === 'paid' ? 'paid' : 'failed',
            ]);
        }

        return response('OK', 200);
    }

    private function completePayment(Payment $payment, ?string $referenceNo = null): void
    {
        $shouldSendEmail = false;

        DB::transaction(function () use ($payment, $referenceNo, &$shouldSendEmail): void {
            $payment = Payment::query()
                ->with(['invoice.repairRequest', 'customer.user'])
                ->lockForUpdate()
                ->findOrFail($payment->id);

            if ($payment->status === 'paid') {
                return;
            }

            $invoice = $payment->invoice;

            $updates = [
                'status' => 'paid',
                'receipt_number' => $payment->receipt_number ?: $this->generateReceiptNumber(),
            ];

            if ($referenceNo) {
                $updates['transaction_reference'] = $referenceNo;
            }

            if (Schema::hasColumn('payments', 'gateway_status')) {
                $updates['gateway_status'] = 'paid';
            }

            if (Schema::hasColumn('payments', 'paid_at')) {
                $updates['paid_at'] = now();
            }

            $payment->update($updates);

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

            $shouldSendEmail = true;
        });

        if (! $shouldSendEmail) {
            return;
        }

        $payment->loadMissing('customer.user');

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
