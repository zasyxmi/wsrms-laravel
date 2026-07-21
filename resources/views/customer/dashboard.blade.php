<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1">
            <h2 class="font-extrabold text-2xl text-slate-900 leading-tight">
                Customer Dashboard
            </h2>
            <p class="text-sm text-slate-500">
                Track repairs, invoices, payments, receipts, and pickup updates.
            </p>
        </div>
    </x-slot>

    @php
        $activeRepairsCount = $summary['pending_repairs'];
        $summaryCards = [
            [
                'label' => 'Active Repairs',
                'value' => $activeRepairsCount,
                'icon' => '🛠️',
                'tone' => 'text-blue-600 bg-blue-50',
            ],
            [
                'label' => 'Completed Repairs',
                'value' => $summary['completed_repairs'],
                'icon' => '✅',
                'tone' => 'text-green-600 bg-green-50',
            ],
            [
                'label' => 'Unpaid Invoices',
                'value' => $summary['unpaid_invoices'],
                'icon' => '📄',
                'tone' => 'text-red-600 bg-red-50',
            ],
            [
                'label' => 'Paid Invoices',
                'value' => $summary['paid_invoices'],
                'icon' => '💳',
                'tone' => 'text-purple-600 bg-purple-50',
            ],
        ];
    @endphp

    <div class="py-6 bg-slate-50 ws-dashboard">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-7">

            @if (session('success'))
                <div class="ws-card p-4 border-l-4 border-green-500 bg-green-50">
                    <p class="text-green-700 font-semibold">{{ session('success') }}</p>
                </div>
            @endif

            @if (session('error'))
                <div class="ws-card p-4 border-l-4 border-red-500 bg-red-50">
                    <p class="text-red-700 font-semibold">{{ session('error') }}</p>
                </div>
            @endif

            {{-- Compact Welcome Header --}}
            <section class="ws-card p-6" data-gsap="hero">
                <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
                    <div class="max-w-3xl">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 text-blue-700 text-xs font-extrabold">
                            <span>👋</span>
                            Customer Portal
                        </div>

                        <h3 class="mt-3 text-2xl font-extrabold text-slate-900">
                            Welcome back, {{ auth()->user()->name }}
                        </h3>

                        <p class="mt-2 text-sm text-slate-600 leading-relaxed">
                            Track your repair progress, review invoices, make payments, and download receipts from one place.
                        </p>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3">
                        <a href="{{ route('customer.repair-requests.create') }}" class="ws-btn-primary !w-auto">
                            Submit Repair Request
                        </a>

                        <a href="{{ route('customer.repair-requests.index') }}" class="ws-btn-secondary !w-auto">
                            View My Repairs
                        </a>
                    </div>
                </div>
            </section>

            {{-- Current Repair / Next Action --}}
            <section class="space-y-4" data-gsap="fade-up">
                <div>
                    <h3 class="text-lg font-extrabold text-slate-900">Current Repair / Next Action</h3>
                    <p class="text-sm text-slate-500">The latest repair item that may need your attention.</p>
                </div>

                <div class="ws-card p-5" data-gsap="scale-in">
                    @if ($currentRepairRequest)
                        @php
                            $invoice = $currentRepairRequest->invoice;
                            $invoiceStatus = $invoice?->status;
                            $status = $currentRepairRequest->status;

                            if ($status === 'completed') {
                                $nextActionMessage = 'Your device has been collected. This repair is fully completed. Thank you!';
                            } elseif ($status === 'ready_for_pickup' || $invoiceStatus === 'paid') {
                                $nextActionMessage = 'Your device is ready for pickup.';
                            } elseif ($status === 'waiting_payment' || $invoiceStatus === 'unpaid') {
                                $nextActionMessage = 'Payment is required before pickup.';
                            } elseif ($status === 'repair_completed') {
                                $nextActionMessage = 'Your repair is done. Please wait for the admin to generate your invoice.';
                            } else {
                                $nextActionMessage = match ($status) {
                                    'submitted' => 'Your request is waiting for admin review.',
                                    'approved' => 'Please bring your device to the workshop.',
                                    'assigned' => 'Your technician has been assigned. Please bring your device if not yet submitted.',
                                    'under_diagnosis' => 'The technician is diagnosing your device.',
                                    'in_repair' => 'Your device is currently being repaired.',
                                    'waiting_for_parts' => 'Your repair is waiting for spare parts.',
                                    default => 'Check your repair details for the latest update.',
                                };
                            }

                            $statusLabel = in_array($status, ['approved', 'assigned'], true)
                                ? 'Approved - Waiting for Device'
                                : ucwords(str_replace('_', ' ', $status));
                        @endphp

                        <div class="flex flex-col gap-5 lg:flex-row lg:items-start lg:justify-between">
                            <div class="space-y-4">
                                <div>
                                    <p class="text-xs font-extrabold uppercase text-slate-500">Repair Request</p>
                                    <h4 class="mt-1 text-xl font-extrabold text-slate-900">
                                        {{ $currentRepairRequest->repair_code }}
                                    </h4>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                                    <div>
                                        <p class="text-xs font-bold text-slate-500">Device</p>
                                        <p class="font-semibold text-slate-900">
                                            {{ $currentRepairRequest->device?->device_type ?? 'Device' }}
                                            ·
                                            {{ trim(($currentRepairRequest->device?->brand ?? '') . ' ' . ($currentRepairRequest->device?->model ?? '')) ?: '-' }}
                                        </p>
                                    </div>

                                    <div>
                                        <p class="text-xs font-bold text-slate-500">Status</p>
                                        <span class="mt-1 ws-badge ws-status-{{ str_replace('_', '-', $status) }}">
                                            {{ $statusLabel }}
                                        </span>
                                    </div>

                                    <div>
                                        <p class="text-xs font-bold text-slate-500">Technician</p>
                                        <p class="font-semibold text-slate-900">
                                            {{ $currentRepairRequest->technician?->user?->name ?? 'Not assigned yet' }}
                                        </p>
                                    </div>

                                    <div>
                                        <p class="text-xs font-bold text-slate-500">Submitted</p>
                                        <p class="font-semibold text-slate-900">
                                            {{ $currentRepairRequest->request_date ? $currentRepairRequest->request_date->format('d M Y') : '-' }}
                                        </p>
                                    </div>
                                </div>

                                <div class="rounded-xl bg-blue-50 p-4 text-sm font-semibold text-blue-800">
                                    {{ $nextActionMessage }}
                                </div>
                            </div>

                            <div class="flex flex-col gap-2 sm:flex-row lg:flex-col lg:min-w-40">
                                <a href="{{ route('customer.repair-requests.show', $currentRepairRequest) }}" class="ws-btn-primary !w-auto">
                                    View Details
                                </a>

                                @if ($invoice)
                                    <a href="{{ route('customer.invoices.show', $invoice) }}" class="ws-btn-secondary !w-auto">
                                        View Invoice
                                    </a>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <h4 class="font-extrabold text-slate-900">You currently have no active repair request.</h4>
                                <p class="mt-1 text-sm text-slate-500">
                                    Submit a repair request when you are ready to send a device for inspection.
                                </p>
                            </div>

                            <a href="{{ route('customer.repair-requests.create') }}" class="ws-btn-primary !w-auto">
                                Submit Repair Request
                            </a>
                        </div>
                    @endif
                </div>
            </section>

            {{-- Latest Repair Requests --}}
            <section class="ws-card overflow-hidden" data-gsap="fade-up">
                <div class="px-5 py-4 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div>
                        <h3 class="text-lg font-extrabold text-slate-900">Latest Repair Requests</h3>
                        <p class="text-sm text-slate-500">Your most recent repair activity.</p>
                    </div>

                    <a href="{{ route('customer.repair-requests.index') }}" class="ws-btn-secondary !w-auto !py-2">
                        View All Repairs
                    </a>
                </div>

                <div class="overflow-x-auto bg-white">
                    <table class="min-w-full text-sm">
                        <thead class="bg-slate-100 text-slate-600">
                            <tr>
                                <th class="px-5 py-3 text-left font-extrabold">Repair Code</th>
                                <th class="px-5 py-3 text-left font-extrabold">Device</th>
                                <th class="px-5 py-3 text-left font-extrabold">Status</th>
                                <th class="px-5 py-3 text-left font-extrabold">Invoice</th>
                                <th class="px-5 py-3 text-left font-extrabold">Action</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-200">
                            @forelse ($latestRepairRequests as $repairRequest)
                                @php
                                    $statusLabel = in_array($repairRequest->status, ['approved', 'assigned'], true)
                                        ? 'Approved - Waiting for Device'
                                        : ucwords(str_replace('_', ' ', $repairRequest->status));
                                @endphp

                                <tr class="hover:bg-slate-50 transition">
                                    <td class="px-5 py-4 font-extrabold text-slate-900 whitespace-nowrap">
                                        {{ $repairRequest->repair_code }}
                                    </td>

                                    <td class="px-5 py-4">
                                        <p class="font-semibold text-slate-900">
                                            {{ $repairRequest->device?->brand ?? '-' }}
                                            {{ $repairRequest->device?->model ?? '' }}
                                        </p>
                                        <p class="text-xs text-slate-500">
                                            {{ $repairRequest->device?->device_type ?? 'Device' }}
                                            @if ($repairRequest->technician)
                                                · {{ $repairRequest->technician?->user?->name }}
                                            @endif
                                        </p>
                                    </td>

                                    <td class="px-5 py-4">
                                        <span class="ws-badge ws-status-{{ str_replace('_', '-', $repairRequest->status) }}">
                                            {{ $statusLabel }}
                                        </span>
                                    </td>

                                    <td class="px-5 py-4">
                                        @if ($repairRequest->invoice)
                                            <span class="ws-badge ws-status-{{ $repairRequest->invoice->status }}">
                                                {{ ucwords($repairRequest->invoice->status) }}
                                            </span>
                                        @else
                                            <span class="inline-flex px-3 py-1 rounded-full bg-slate-200 text-slate-700 text-xs font-extrabold">
                                                No Invoice
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-5 py-4 whitespace-nowrap">
                                        <a href="{{ route('customer.repair-requests.show', $repairRequest) }}"
                                           class="inline-flex items-center px-3 py-2 rounded-xl bg-blue-50 text-blue-700 text-xs font-extrabold hover:bg-blue-600 hover:text-white transition">
                                            View
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-5 py-8 text-center text-slate-500">
                                        No repair requests found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>

            {{-- Account Summary --}}
            <section class="space-y-4" data-gsap="fade-up">
                <div>
                    <h3 class="text-lg font-extrabold text-slate-900">Account Summary</h3>
                    <p class="text-sm text-slate-500">A compact snapshot of your repair and invoice history.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4" data-gsap-stagger>
                    @foreach ($summaryCards as $card)
                        <div class="ws-card p-4" data-gsap-item>
                            <div class="flex items-center justify-between gap-3">
                                <div>
                                    <p class="text-2xl font-extrabold text-slate-900">{{ $card['value'] }}</p>
                                    <p class="mt-1 text-sm font-bold text-slate-500">{{ $card['label'] }}</p>
                                </div>

                                <div class="w-10 h-10 rounded-xl {{ $card['tone'] }} flex items-center justify-center">
                                    {{ $card['icon'] }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            {{-- Need Help --}}
            <section class="ws-card p-5" data-gsap="fade-up">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <h3 class="text-lg font-extrabold text-slate-900">Need Help?</h3>
                        <p class="mt-1 text-sm text-slate-600">
                            Check updates from the workshop or review your full repair history anytime.
                        </p>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3">
                        <a href="{{ route('notifications.index') }}" class="ws-btn-primary !w-auto">
                            Check Notifications
                        </a>

                        <a href="{{ route('customer.repair-requests.index') }}" class="ws-btn-secondary !w-auto">
                            View Repair History
                        </a>
                    </div>
                </div>
            </section>

        </div>
    </div>
</x-app-layout>
