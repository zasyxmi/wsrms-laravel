<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Receipt Details
            </h2>

            <div class="flex gap-3">
                <a href="{{ route('customer.receipts.download', $payment) }}"
                    class="px-4 py-2 bg-blue-600 text-white rounded-md text-sm hover:bg-blue-700">
                    Download PDF
                </a>

                <a href="{{ route('customer.invoices.show', $payment->invoice) }}"
                    class="px-4 py-2 bg-gray-600 text-white rounded-md text-sm hover:bg-gray-700">
                    Back to Invoice
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-8 space-y-6">

                    <div class="text-center border-b pb-6">
                        <h1 class="text-2xl font-bold text-gray-900">
                            Workshop Repair Service Management System
                        </h1>

                        <p class="text-gray-600 mt-1">
                            Official Payment Receipt
                        </p>
                    </div>

                    <div class="flex items-center justify-between border-b pb-4">
                        <div>
                            <p class="text-sm text-gray-500">Receipt Number</p>
                            <h3 class="text-2xl font-bold text-gray-900">
                                {{ $payment->receipt_number }}
                            </h3>
                        </div>

                        <span class="px-3 py-1 rounded-full text-sm bg-green-100 text-green-700">
                            Paid
                        </span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-sm text-gray-500">Payment Number</p>
                            <p class="font-medium">
                                {{ $payment->payment_number }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">Invoice Number</p>
                            <p class="font-medium">
                                {{ $payment->invoice->invoice_number }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">Repair Code</p>
                            <p class="font-medium">
                                {{ $payment->invoice->repairRequest->repair_code }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">Payment Date</p>
                            <p class="font-medium">
                                {{ $payment->paid_at ? $payment->paid_at->format('d M Y, h:i A') : '-' }}
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
                            <p class="text-sm text-gray-500">Device</p>
                            <p class="font-medium">
                                {{ $payment->invoice->repairRequest->device->brand }}
                                {{ $payment->invoice->repairRequest->device->model }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">Payment Method</p>
                            <p class="font-medium">
                                {{ ucwords($payment->payment_method) }}
                            </p>
                        </div>
                    </div>

                    <div class="border-t pt-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">
                            Payment Breakdown
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
                        <h3 class="text-lg font-bold text-gray-900 mb-3">
                            Transaction Details
                        </h3>

                        <div class="bg-gray-50 p-4 rounded-md space-y-2">
                            <p class="text-gray-700">
                                <span class="font-semibold">Transaction Reference:</span>
                                {{ $payment->transaction_reference }}
                            </p>

                            <p class="text-gray-700">
                                <span class="font-semibold">Payment Status:</span>
                                {{ ucwords($payment->status) }}
                            </p>
                        </div>
                    </div>

                    <div class="border-t pt-6 text-center">
                        <p class="text-gray-600">
                            Thank you for using our workshop repair service.
                        </p>

                        <p class="text-sm text-gray-500 mt-1">
                            This receipt is generated by the system after successful payment.
                        </p>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>