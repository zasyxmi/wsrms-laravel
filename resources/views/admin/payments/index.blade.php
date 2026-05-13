<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Payment Management
            </h2>

            <a href="{{ route('dashboard') }}"
               class="px-4 py-2 bg-gray-600 text-white rounded-md text-sm hover:bg-gray-700">
                Back to Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <div class="p-6">
                    <h3 class="text-lg font-bold mb-4">
                        All Payments
                    </h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full border border-gray-200 text-sm">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="border px-4 py-2 text-left">Payment No.</th>
                                    <th class="border px-4 py-2 text-left">Receipt No.</th>
                                    <th class="border px-4 py-2 text-left">Invoice No.</th>
                                    <th class="border px-4 py-2 text-left">Customer</th>
                                    <th class="border px-4 py-2 text-left">Device</th>
                                    <th class="border px-4 py-2 text-left">Amount Paid</th>
                                    <th class="border px-4 py-2 text-left">Method</th>
                                    <th class="border px-4 py-2 text-left">Status</th>
                                    <th class="border px-4 py-2 text-left">Paid At</th>
                                    <th class="border px-4 py-2 text-left">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($payments as $payment)
                                    <tr>
                                        <td class="border px-4 py-2 font-semibold">
                                            {{ $payment->payment_number }}
                                        </td>

                                        <td class="border px-4 py-2">
                                            {{ $payment->receipt_number ?? '-' }}
                                        </td>

                                        <td class="border px-4 py-2">
                                            {{ $payment->invoice->invoice_number }}
                                        </td>

                                        <td class="border px-4 py-2">
                                            {{ $payment->customer->user->name }}
                                        </td>

                                        <td class="border px-4 py-2">
                                            {{ $payment->invoice->repairRequest->device->brand }}
                                            {{ $payment->invoice->repairRequest->device->model }}
                                        </td>

                                        <td class="border px-4 py-2 font-semibold">
                                            RM {{ number_format($payment->amount_paid, 2) }}
                                        </td>

                                        <td class="border px-4 py-2">
                                            {{ ucwords($payment->payment_method) }}
                                        </td>

                                        <td class="border px-4 py-2">
                                            @if ($payment->status === 'paid')
                                                <span class="px-2 py-1 rounded text-xs bg-green-100 text-green-700">
                                                    Paid
                                                </span>
                                            @else
                                                <span class="px-2 py-1 rounded text-xs bg-yellow-100 text-yellow-700">
                                                    {{ ucwords($payment->status) }}
                                                </span>
                                            @endif
                                        </td>

                                        <td class="border px-4 py-2">
                                            {{ $payment->paid_at ? $payment->paid_at->format('d M Y, h:i A') : '-' }}
                                        </td>

                                        <td class="border px-4 py-2">
                                            <a href="{{ route('admin.payments.show', $payment) }}"
                                               class="text-blue-600 hover:underline">
                                                View Details
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="border px-4 py-4 text-center text-gray-500">
                                            No payments found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $payments->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>