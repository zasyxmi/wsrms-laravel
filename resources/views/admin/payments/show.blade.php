<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Payment Details
            </h2>

            <a href="{{ route('admin.payments.index') }}"
               class="px-4 py-2 bg-gray-600 text-white rounded-md text-sm hover:bg-gray-700">
                Back to Payments
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 space-y-6">

                    <div class="flex items-center justify-between border-b pb-4">
                        <div>
                            <p class="text-sm text-gray-500">Payment Number</p>
                            <h3 class="text-2xl font-bold text-gray-900">
                                {{ $payment->payment_number }}
                            </h3>
                        </div>

                        <span class="px-3 py-1 rounded-full text-sm bg-green-100 text-green-700">
                            {{ ucwords($payment->status) }}
                        </span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-sm text-gray-500">Receipt Number</p>
                            <p class="font-medium">
                                {{ $payment->receipt_number ?? '-' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">Invoice Number</p>
                            <p class="font-medium">
                                {{ $payment->invoice->invoice_number }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">Customer Name</p>
                            <p class="font-medium">
                                {{ $payment->customer->user->name }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">Customer Email</p>
                            <p class="font-medium">
                                {{ $payment->customer->user->email }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">Repair Code</p>
                            <p class="font-medium">
                                {{ $payment->invoice->repairRequest->repair_code }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">Device</p>
                            <p class="font-medium">
                                {{ $payment->invoice->repairRequest->device->brand }}
                                {{ $payment->invoice->repairRequest->device->model }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">Technician</p>
                            <p class="font-medium">
                                {{ $payment->invoice->repairRequest->technician?->user?->name ?? '-' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">Paid At</p>
                            <p class="font-medium">
                                {{ $payment->paid_at ? $payment->paid_at->format('d M Y, h:i A') : '-' }}
                            </p>
                        </div>
                    </div>

                    <div class="border-t pt-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">
                            Payment Information
                        </h3>

                        <div class="bg-gray-50 p-4 rounded-md space-y-2">
                            <p class="text-gray-700">
                                <span class="font-semibold">Payment Method:</span>
                                {{ ucwords($payment->payment_method) }}
                            </p>

                            <p class="text-gray-700">
                                <span class="font-semibold">Transaction Reference:</span>
                                {{ $payment->transaction_reference }}
                            </p>

                            <p class="text-gray-700">
                                <span class="font-semibold">Amount Paid:</span>
                                RM {{ number_format($payment->amount_paid, 2) }}
                            </p>

                            @if ($payment->gateway)
                                <p class="text-gray-700">
                                    <span class="font-semibold">Gateway:</span>
                                    {{ $payment->gateway }}
                                </p>

                                <p class="text-gray-700">
                                    <span class="font-semibold">Gateway Bill Code:</span>
                                    {{ $payment->gateway_bill_code ?? '-' }}
                                </p>

                                <p class="text-gray-700">
                                    <span class="font-semibold">Gateway Reference:</span>
                                    {{ $payment->gateway_reference ?? '-' }}
                                </p>

                                <p class="text-gray-700">
                                    <span class="font-semibold">Gateway Status:</span>
                                    {{ $payment->gateway_status ? ucwords($payment->gateway_status) : '-' }}
                                </p>
                            @endif
                        </div>
                    </div>

                    <div class="border-t pt-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">
                            Invoice Breakdown
                        </h3>

                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Diagnosis Fee</span>
                                <span class="font-medium">
                                    RM {{ number_format($payment->invoice->diagnosis_fee, 2) }}
                                </span>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-gray-600">Service Charge</span>
                                <span class="font-medium">
                                    RM {{ number_format($payment->invoice->service_charge, 2) }}
                                </span>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-gray-600">Spare Part Total</span>
                                <span class="font-medium">
                                    RM {{ number_format($payment->invoice->spare_part_total, 2) }}
                                </span>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-gray-600">Additional Charge</span>
                                <span class="font-medium">
                                    RM {{ number_format($payment->invoice->additional_charge, 2) }}
                                </span>
                            </div>

                            <div class="border-t pt-3 flex justify-between text-lg">
                                <span class="font-bold text-gray-900">Total Paid</span>
                                <span class="font-bold text-gray-900">
                                    RM {{ number_format($payment->amount_paid, 2) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="border-t pt-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">
                            Spare Parts Used
                        </h3>

                        <div class="overflow-x-auto">
                            <table class="min-w-full border border-gray-200 text-sm">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="border px-4 py-2 text-left">Part Name</th>
                                        <th class="border px-4 py-2 text-left">Unit Price</th>
                                        <th class="border px-4 py-2 text-left">Quantity</th>
                                        <th class="border px-4 py-2 text-left">Subtotal</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse ($payment->invoice->repairRequest->repairSpareParts as $repairSparePart)
                                        <tr>
                                            <td class="border px-4 py-2">
                                                {{ $repairSparePart->sparePart->part_name }}
                                            </td>

                                            <td class="border px-4 py-2">
                                                RM {{ number_format($repairSparePart->unit_price, 2) }}
                                            </td>

                                            <td class="border px-4 py-2">
                                                {{ $repairSparePart->quantity_used }}
                                            </td>

                                            <td class="border px-4 py-2 font-semibold">
                                                RM {{ number_format($repairSparePart->subtotal, 2) }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="border px-4 py-4 text-center text-gray-500">
                                                No spare parts recorded for this repair.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
