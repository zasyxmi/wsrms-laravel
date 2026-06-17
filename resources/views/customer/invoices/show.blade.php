<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Invoice Details
            </h2>

            <a href="{{ route('customer.repair-requests.show', $invoice->repairRequest) }}"
                class="px-4 py-2 bg-gray-600 text-white rounded-md text-sm hover:bg-gray-700">
                Back
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-md">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 space-y-6">

                    <div class="flex items-center justify-between border-b pb-4">
                        <div>
                            <p class="text-sm text-gray-500">Invoice Number</p>
                            <h3 class="text-2xl font-bold text-gray-900">
                                {{ $invoice->invoice_number }}
                            </h3>
                        </div>

                        <span class="px-3 py-1 rounded-full text-sm bg-red-100 text-red-700">
                            {{ ucwords($invoice->status) }}
                        </span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-sm text-gray-500">Repair Code</p>
                            <p class="font-medium">
                                {{ $invoice->repairRequest->repair_code }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">Generated Date</p>
                            <p class="font-medium">
                                {{ $invoice->generated_at ? $invoice->generated_at->format('d M Y, h:i A') : '-' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">Device</p>
                            <p class="font-medium">
                                {{ $invoice->repairRequest->device->brand }}
                                {{ $invoice->repairRequest->device->model }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">Repair Status</p>
                            <p class="font-medium">
                                {{ ucwords(str_replace('_', ' ', $invoice->repairRequest->status)) }}
                            </p>
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
                                    @forelse ($invoice->repairRequest->repairSpareParts as $repairSparePart)
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
                                                No spare parts were recorded for this repair.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="border-t pt-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">
                            Payment Summary
                        </h3>

                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Diagnosis Fee</span>
                                <span class="font-medium">
                                    RM {{ number_format($invoice->diagnosis_fee, 2) }}
                                </span>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-gray-600">Service Charge</span>
                                <span class="font-medium">
                                    RM {{ number_format($invoice->service_charge, 2) }}
                                </span>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-gray-600">Spare Part Total</span>
                                <span class="font-medium">
                                    RM {{ number_format($invoice->spare_part_total, 2) }}
                                </span>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-gray-600">Additional Charge</span>
                                <span class="font-medium">
                                    RM {{ number_format($invoice->additional_charge, 2) }}
                                </span>
                            </div>

                            <div class="border-t pt-3 flex justify-between text-lg">
                                <span class="font-bold text-gray-900">Total Amount</span>
                                <span class="font-bold text-gray-900">
                                    RM {{ number_format($invoice->total_amount, 2) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="border-t pt-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-3">
                            Payment Status
                        </h3>

                        @if ($invoice->status === 'paid')
                            <div class="bg-green-50 p-4 rounded-md">
                                <p class="text-green-800 font-semibold">
                                    This invoice has been paid.
                                </p>

                                @if ($invoice->payment)
                                    <div class="mt-3 space-y-1">
                                        <p class="text-gray-700">
                                            Payment Number: {{ $invoice->payment->payment_number }}
                                        </p>

                                        <p class="text-gray-700">
                                            Receipt Number: {{ $invoice->payment->receipt_number }}
                                        </p>

                                        <p class="text-gray-700">
                                            Paid At:
                                            {{ $invoice->payment->paid_at ? $invoice->payment->paid_at->format('d M Y, h:i A') : '-' }}
                                        </p>
                                    </div>

                                    <div class="mt-4">
                                        <a href="{{ route('customer.receipts.show', $invoice->payment) }}"
                                            class="inline-block px-4 py-2 bg-blue-600 text-white rounded-md text-sm hover:bg-blue-700">
                                            View Receipt
                                        </a>
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="bg-red-50 p-4 rounded-md">
                                <p class="text-red-800 font-semibold">
                                    This invoice is currently unpaid.
                                </p>

                                <p class="text-gray-700 mt-1 mb-4">
                                    Choose a payment option for this invoice.
                                </p>

                                <div class="flex flex-col sm:flex-row gap-3">
                                    <form method="POST" action="{{ route('customer.invoices.pay', $invoice) }}"
                                        onsubmit="return confirm('Proceed with payment simulation?');">
                                        @csrf

                                        <button type="submit"
                                            class="px-4 py-2 bg-blue-600 text-white rounded-md text-sm hover:bg-blue-700">
                                            Pay Simulation
                                        </button>
                                    </form>

                                    <form method="POST" action="{{ route('customer.toyyibpay.pay', $invoice) }}">
                                        @csrf

                                        <button type="submit"
                                            class="px-4 py-2 bg-green-600 text-white rounded-md text-sm hover:bg-green-700">
                                            Pay with ToyyibPay Sandbox
                                        </button>
                                    </form>
                                </div>

                                <p class="text-gray-600 text-sm mt-3">
                                    Sandbox payment redirects to ToyyibPay test payment page.
                                </p>
                            </div>
                        @endif
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
