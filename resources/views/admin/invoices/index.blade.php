<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Invoice Management
            </h2>

            <a href="{{ route('dashboard') }}"
               class="px-4 py-2 bg-gray-600 text-white rounded-md text-sm hover:bg-gray-700">
                Back to Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

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

            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <div class="p-6">
                    <h3 class="text-lg font-bold mb-4">
                        Pending Invoice Generation
                    </h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full border border-gray-200 text-sm">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="border px-4 py-2 text-left">Repair Code</th>
                                    <th class="border px-4 py-2 text-left">Customer</th>
                                    <th class="border px-4 py-2 text-left">Device</th>
                                    <th class="border px-4 py-2 text-left">Repair Status</th>
                                    <th class="border px-4 py-2 text-left">Completed Date</th>
                                    <th class="border px-4 py-2 text-left">Assigned Technician</th>
                                    <th class="border px-4 py-2 text-left">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($pendingInvoiceRepairRequests as $repairRequest)
                                    <tr>
                                        <td class="border px-4 py-2 font-semibold">
                                            {{ $repairRequest->repair_code }}
                                        </td>

                                        <td class="border px-4 py-2">
                                            {{ $repairRequest->customer?->user?->name ?? '-' }}
                                        </td>

                                        <td class="border px-4 py-2">
                                            {{ $repairRequest->device?->brand ?? '-' }}
                                            {{ $repairRequest->device?->model ?? '' }}
                                        </td>

                                        <td class="border px-4 py-2">
                                            <span class="ws-badge ws-status-{{ str_replace('_', '-', $repairRequest->status) }}">
                                                {{ ucwords(str_replace('_', ' ', $repairRequest->status)) }}
                                            </span>
                                        </td>

                                        <td class="border px-4 py-2">
                                            {{ $repairRequest->completed_date ? $repairRequest->completed_date->format('d M Y') : '-' }}
                                        </td>

                                        <td class="border px-4 py-2">
                                            {{ $repairRequest->technician?->user?->name ?? '-' }}
                                        </td>

                                        <td class="border px-4 py-2">
                                            <a href="{{ route('admin.invoices.create', $repairRequest) }}"
                                               class="text-blue-600 hover:underline font-semibold">
                                                Generate Invoice
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="border px-4 py-4 text-center text-gray-500">
                                            No repair requests are waiting for invoice generation.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="mt-6 bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <div class="p-6">
                    <h3 class="text-lg font-bold mb-4">
                        Invoice History
                    </h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full border border-gray-200 text-sm">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="border px-4 py-2 text-left">Invoice No.</th>
                                    <th class="border px-4 py-2 text-left">Repair Code</th>
                                    <th class="border px-4 py-2 text-left">Customer</th>
                                    <th class="border px-4 py-2 text-left">Device</th>
                                    <th class="border px-4 py-2 text-left">Total Amount</th>
                                    <th class="border px-4 py-2 text-left">Invoice Status</th>
                                    <th class="border px-4 py-2 text-left">Payment Status</th>
                                    <th class="border px-4 py-2 text-left">Generated At</th>
                                    <th class="border px-4 py-2 text-left">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($invoices as $invoice)
                                    <tr>
                                        <td class="border px-4 py-2 font-semibold">
                                            {{ $invoice->invoice_number }}
                                        </td>

                                        <td class="border px-4 py-2">
                                            {{ $invoice->repairRequest->repair_code }}
                                        </td>

                                        <td class="border px-4 py-2">
                                            {{ $invoice->customer->user->name }}
                                        </td>

                                        <td class="border px-4 py-2">
                                            {{ $invoice->repairRequest->device->brand }}
                                            {{ $invoice->repairRequest->device->model }}
                                        </td>

                                        <td class="border px-4 py-2 font-semibold">
                                            RM {{ number_format($invoice->total_amount, 2) }}
                                        </td>

                                        <td class="border px-4 py-2">
                                            @if ($invoice->status === 'paid')
                                                <span class="px-2 py-1 rounded text-xs bg-green-100 text-green-700">
                                                    Paid
                                                </span>
                                            @else
                                                <span class="px-2 py-1 rounded text-xs bg-red-100 text-red-700">
                                                    Unpaid
                                                </span>
                                            @endif
                                        </td>

                                        <td class="border px-4 py-2">
                                            {{ $invoice->payment ? ucwords($invoice->payment->status) : 'No payment yet' }}
                                        </td>

                                        <td class="border px-4 py-2">
                                            {{ $invoice->generated_at ? $invoice->generated_at->format('d M Y, h:i A') : '-' }}
                                        </td>

                                        <td class="border px-4 py-2">
                                            <a href="{{ route('admin.invoices.show', $invoice) }}"
                                               class="text-blue-600 hover:underline">
                                                View Details
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="border px-4 py-4 text-center text-gray-500">
                                            No invoices found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $invoices->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
