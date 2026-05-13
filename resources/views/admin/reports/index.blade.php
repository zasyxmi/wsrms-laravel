<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Admin Reports
            </h2>

            <a href="{{ route('dashboard') }}"
               class="px-4 py-2 bg-gray-600 text-white rounded-md text-sm hover:bg-gray-700">
                Back to Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-900">
                        System Report Overview
                    </h3>

                    <p class="text-gray-600 mt-1">
                        This page summarizes repair progress, invoice records, payment records, and spare part stock status.
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <p class="text-sm text-gray-500">Total Invoices</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">
                        {{ $invoiceSummary['total_invoices'] }}
                    </p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <p class="text-sm text-gray-500">Paid Invoices</p>
                    <p class="text-3xl font-bold text-green-600 mt-2">
                        {{ $invoiceSummary['paid_invoices'] }}
                    </p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <p class="text-sm text-gray-500">Unpaid Invoices</p>
                    <p class="text-3xl font-bold text-red-600 mt-2">
                        {{ $invoiceSummary['unpaid_invoices'] }}
                    </p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <p class="text-sm text-gray-500">Total Amount Received</p>
                    <p class="text-3xl font-bold text-purple-600 mt-2">
                        RM {{ number_format($paymentSummary['total_amount_received'], 2) }}
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">
                            Repair Status Report
                        </h3>

                        <div class="overflow-x-auto">
                            <table class="min-w-full border border-gray-200 text-sm">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="border px-4 py-2 text-left">Status</th>
                                        <th class="border px-4 py-2 text-left">Total</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($repairStatusCounts as $status => $total)
                                        <tr>
                                            <td class="border px-4 py-2">
                                                {{ ucwords(str_replace('_', ' ', $status)) }}
                                            </td>

                                            <td class="border px-4 py-2 font-semibold">
                                                {{ $total }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">
                            Invoice and Payment Summary
                        </h3>

                        <div class="space-y-3">
                            <div class="flex justify-between border-b pb-2">
                                <span class="text-gray-600">Total Invoice Amount</span>
                                <span class="font-semibold">
                                    RM {{ number_format($invoiceSummary['total_invoice_amount'], 2) }}
                                </span>
                            </div>

                            <div class="flex justify-between border-b pb-2">
                                <span class="text-gray-600">Total Payments</span>
                                <span class="font-semibold">
                                    {{ $paymentSummary['total_payments'] }}
                                </span>
                            </div>

                            <div class="flex justify-between border-b pb-2">
                                <span class="text-gray-600">Successful Payments</span>
                                <span class="font-semibold text-green-700">
                                    {{ $paymentSummary['successful_payments'] }}
                                </span>
                            </div>

                            <div class="flex justify-between border-b pb-2">
                                <span class="text-gray-600">Total Amount Received</span>
                                <span class="font-semibold text-purple-700">
                                    RM {{ number_format($paymentSummary['total_amount_received'], 2) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">
                        Low Stock Spare Parts
                    </h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full border border-gray-200 text-sm">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="border px-4 py-2 text-left">Part Name</th>
                                    <th class="border px-4 py-2 text-left">Category</th>
                                    <th class="border px-4 py-2 text-left">Unit Price</th>
                                    <th class="border px-4 py-2 text-left">Stock Quantity</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($lowStockParts as $sparePart)
                                    <tr>
                                        <td class="border px-4 py-2 font-semibold">
                                            {{ $sparePart->part_name }}
                                        </td>

                                        <td class="border px-4 py-2">
                                            {{ $sparePart->category }}
                                        </td>

                                        <td class="border px-4 py-2">
                                            RM {{ number_format($sparePart->unit_price, 2) }}
                                        </td>

                                        <td class="border px-4 py-2">
                                            <span class="px-2 py-1 rounded text-xs bg-yellow-100 text-yellow-700">
                                                {{ $sparePart->stock_quantity }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="border px-4 py-4 text-center text-gray-500">
                                            No low stock spare parts found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">
                        Recent Payments
                    </h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full border border-gray-200 text-sm">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="border px-4 py-2 text-left">Payment No.</th>
                                    <th class="border px-4 py-2 text-left">Invoice No.</th>
                                    <th class="border px-4 py-2 text-left">Customer</th>
                                    <th class="border px-4 py-2 text-left">Amount Paid</th>
                                    <th class="border px-4 py-2 text-left">Paid At</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($recentPayments as $payment)
                                    <tr>
                                        <td class="border px-4 py-2 font-semibold">
                                            {{ $payment->payment_number }}
                                        </td>

                                        <td class="border px-4 py-2">
                                            {{ $payment->invoice->invoice_number }}
                                        </td>

                                        <td class="border px-4 py-2">
                                            {{ $payment->customer->user->name }}
                                        </td>

                                        <td class="border px-4 py-2 font-semibold">
                                            RM {{ number_format($payment->amount_paid, 2) }}
                                        </td>

                                        <td class="border px-4 py-2">
                                            {{ $payment->paid_at ? $payment->paid_at->format('d M Y, h:i A') : '-' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="border px-4 py-4 text-center text-gray-500">
                                            No payment records found.
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
</x-app-layout>