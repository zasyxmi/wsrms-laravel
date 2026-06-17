<?php

namespace App\Services;

use App\Models\Invoice;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class ToyyibPayService
{
    public function createBill(Invoice $invoice): array
    {
        $invoice->loadMissing([
            'customer.user',
            'repairRequest.device',
        ]);

        $baseUrl = rtrim((string) config('services.toyyibpay.base_url'), '/');
        $secretKey = config('services.toyyibpay.secret_key');
        $categoryCode = config('services.toyyibpay.category_code');

        if (! $baseUrl || ! $secretKey || ! $categoryCode) {
            throw new RuntimeException('ToyyibPay sandbox configuration is incomplete.');
        }

        $externalReference = 'INV-' . $invoice->id . '-' . now()->timestamp;
        $customerUser = $invoice->customer->user;

        $payload = [
            'userSecretKey' => $secretKey,
            'categoryCode' => $categoryCode,
            'billName' => $this->sanitizeText('WSRMS Invoice ' . $invoice->id, 30),
            'billDescription' => $this->sanitizeText('Repair payment invoice ' . $invoice->id, 100),
            'billPriceSetting' => 1,
            'billPayorInfo' => 1,
            'billAmount' => (int) round((float) $invoice->total_amount * 100),
            'billReturnUrl' => route('customer.toyyibpay.return', [], true),
            'billCallbackUrl' => route('toyyibpay.callback', [], true),
            'billExternalReferenceNo' => $externalReference,
            'billTo' => $customerUser->name,
            'billEmail' => $customerUser->email,
            'billPhone' => $customerUser->phone_number ?: '0123456789',
            'billSplitPayment' => 0,
            'billSplitPaymentArgs' => '',
            'billPaymentChannel' => 0,
            'billContentEmail' => 'Thank you for your repair payment.',
            'billChargeToCustomer' => 1,
        ];

        $response = Http::asForm()
            ->timeout(30)
            ->post($baseUrl . '/index.php/api/createBill', $payload);

        if (! $response->successful()) {
            throw new RuntimeException('ToyyibPay bill creation failed with status ' . $response->status() . '.');
        }

        $responseData = $response->json();

        if (! is_array($responseData)) {
            throw new RuntimeException('ToyyibPay returned an invalid bill creation response.');
        }

        $billCode = $responseData['BillCode'] ?? $responseData[0]['BillCode'] ?? null;

        if (! $billCode) {
            throw new RuntimeException('ToyyibPay did not return a bill code.');
        }

        return [
            'bill_code' => $billCode,
            'payment_url' => $baseUrl . '/' . $billCode,
            'external_reference' => $externalReference,
            'raw_response' => $responseData,
        ];
    }

    public function verifyCallbackHash(array $payload): bool
    {
        $receivedHash = (string) ($payload['hash'] ?? '');

        if ($receivedHash === '') {
            return false;
        }

        $expectedHash = md5(
            (string) config('services.toyyibpay.secret_key')
            . (string) ($payload['status'] ?? '')
            . (string) ($payload['order_id'] ?? '')
            . (string) ($payload['refno'] ?? '')
            . 'ok'
        );

        return hash_equals($expectedHash, $receivedHash);
    }

    private function sanitizeText(string $value, int $limit): string
    {
        $clean = preg_replace('/[^A-Za-z0-9 _]/', '', $value) ?: '';
        $clean = trim(preg_replace('/\s+/', ' ', $clean) ?: '');

        return substr($clean, 0, $limit);
    }
}
