<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1">
            <h2 class="font-extrabold text-2xl text-slate-900 leading-tight">
                Customer Dashboard
            </h2>
            <p class="text-sm text-slate-500">
                Submit repair requests, track repair progress, view invoices, make payments, and download receipts.
            </p>
        </div>
    </x-slot>

    <div class="py-8 ws-dashboard">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            @if (session('success'))
                <div class="ws-card p-4 border-l-4 border-green-500 bg-green-50">
                    <p class="text-green-700 font-semibold">
                        {{ session('success') }}
                    </p>
                </div>
            @endif

            @if (session('error'))
                <div class="ws-card p-4 border-l-4 border-red-500 bg-red-50">
                    <p class="text-red-700 font-semibold">
                        {{ session('error') }}
                    </p>
                </div>
            @endif

            {{-- Hero Section --}}
            <div class="ws-card overflow-hidden">
                <div class="grid grid-cols-1 lg:grid-cols-3">
                    <div class="lg:col-span-2 p-8">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 text-blue-700 text-sm font-extrabold mb-4">
                            <span>👋</span>
                            Customer Service Portal
                        </div>

                        <h3 class="text-3xl font-extrabold text-slate-900 tracking-tight">
                            Welcome, {{ auth()->user()->name }}
                        </h3>

                        <p class="mt-3 text-slate-600 max-w-3xl leading-relaxed">
                            Track your PC, laptop, and handphone repair from request submission until payment,
                            receipt download, and pickup notification. Everything is available in one place.
                        </p>

                        <div class="mt-6 flex flex-wrap gap-3">
                            <a href="{{ route('customer.repair-requests.create') }}" class="ws-btn-primary !w-auto">
                                Submit Repair Request
                            </a>

                            <a href="{{ route('customer.repair-requests.index') }}" class="ws-btn-secondary !w-auto">
                                View My Repairs
                            </a>

                            <a href="{{ route('notifications.index') }}" class="ws-btn-secondary !w-auto">
                                View Notifications
                            </a>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-blue-600 to-sky-400 p-8 text-white flex flex-col justify-center">
                        <p class="text-sm font-bold text-blue-100">
                            Repair Services
                        </p>

                        <div class="mt-5 space-y-4">
                            <div class="flex items-center gap-4 bg-white/15 rounded-2xl p-4 backdrop-blur">
                                <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center text-2xl">
                                    💻
                                </div>
                                <div>
                                    <p class="font-extrabold">PC Repair</p>
                                    <p class="text-sm text-blue-100">Desktop, hardware, software, and diagnostics.</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-4 bg-white/15 rounded-2xl p-4 backdrop-blur">
                                <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center text-2xl">
                                    🖥️
                                </div>
                                <div>
                                    <p class="font-extrabold">Laptop Repair</p>
                                    <p class="text-sm text-blue-100">Battery, screen, keyboard, and storage issues.</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-4 bg-white/15 rounded-2xl p-4 backdrop-blur">
                                <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center text-2xl">
                                    📱
                                </div>
                                <div>
                                    <p class="font-extrabold">Handphone Repair</p>
                                    <p class="text-sm text-blue-100">Screen, charging, battery, and device faults.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Summary Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-5 gap-5">
                <div class="ws-card p-6">
                    <div class="flex items-center justify-between">
                        <p class="text-sm font-bold text-slate-500">Total Requests</p>
                        <div class="w-10 h-10 rounded-2xl bg-blue-50 text-blue-700 flex items-center justify-center">
                            📋
                        </div>
                    </div>

                    <p class="mt-4 text-4xl font-extrabold text-slate-900">
                        {{ $summary['total_repair_requests'] }}
                    </p>

                    <p class="mt-1 text-xs font-semibold text-slate-400">
                        All repair requests submitted
                    </p>
                </div>

                <div class="ws-card p-6">
                    <div class="flex items-center justify-between">
                        <p class="text-sm font-bold text-slate-500">Pending Repairs</p>
                        <div class="w-10 h-10 rounded-2xl bg-orange-50 text-orange-700 flex items-center justify-center">
                            ⏳
                        </div>
                    </div>

                    <p class="mt-4 text-4xl font-extrabold text-orange-600">
                        {{ $summary['pending_repairs'] }}
                    </p>

                    <p class="mt-1 text-xs font-semibold text-slate-400">
                        Waiting or currently in progress
                    </p>
                </div>

                <div class="ws-card p-6">
                    <div class="flex items-center justify-between">
                        <p class="text-sm font-bold text-slate-500">Completed Repairs</p>
                        <div class="w-10 h-10 rounded-2xl bg-green-50 text-green-700 flex items-center justify-center">
                            ✅
                        </div>
                    </div>

                    <p class="mt-4 text-4xl font-extrabold text-green-600">
                        {{ $summary['completed_repairs'] }}
                    </p>

                    <p class="mt-1 text-xs font-semibold text-slate-400">
                        Successfully completed jobs
                    </p>
                </div>

                <div class="ws-card p-6">
                    <div class="flex items-center justify-between">
                        <p class="text-sm font-bold text-slate-500">Unpaid Invoices</p>
                        <div class="w-10 h-10 rounded-2xl bg-red-50 text-red-700 flex items-center justify-center">
                            📄
                        </div>
                    </div>

                    <p class="mt-4 text-4xl font-extrabold text-red-600">
                        {{ $summary['unpaid_invoices'] }}
                    </p>

                    <p class="mt-1 text-xs font-semibold text-slate-400">
                        Payment required
                    </p>
                </div>

                <div class="ws-card p-6">
                    <div class="flex items-center justify-between">
                        <p class="text-sm font-bold text-slate-500">Paid Invoices</p>
                        <div class="w-10 h-10 rounded-2xl bg-purple-50 text-purple-700 flex items-center justify-center">
                            💳
                        </div>
                    </div>

                    <p class="mt-4 text-4xl font-extrabold text-purple-600">
                        {{ $summary['paid_invoices'] }}
                    </p>

                    <p class="mt-1 text-xs font-semibold text-slate-400">
                        Payment completed
                    </p>
                </div>
            </div>

            {{-- Reminder + Quick Flow --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
                <div class="ws-card p-6 lg:col-span-2">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-blue-100 text-blue-700 flex items-center justify-center text-2xl">
                            🔔
                        </div>

                        <div>
                            <h3 class="text-lg font-extrabold text-slate-900">
                                Repair Status Reminder
                            </h3>

                            <p class="mt-2 text-slate-600 leading-relaxed">
                                Please check your invoice once the repair is completed. After payment is successful,
                                the system will generate your receipt and send a pickup notification through the system
                                and email.
                            </p>

                            <div class="mt-4 flex flex-wrap gap-3">
                                <span class="ws-badge ws-status-submitted">Submit Request</span>
                                <span class="ws-badge ws-status-approved">Admin Approval</span>
                                <span class="ws-badge ws-status-assigned">Technician Assigned</span>
                                <span class="ws-badge ws-status-completed">Ready for Payment</span>
                                <span class="ws-badge ws-status-paid">Pickup Ready</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="ws-card p-6">
                    <h3 class="text-lg font-extrabold text-slate-900">
                        Need Support?
                    </h3>

                    <p class="mt-2 text-sm text-slate-600 leading-relaxed">
                        Contact the workshop if you need clarification about your repair status, invoice, or pickup.
                    </p>

                    <div class="mt-5 space-y-3">
                        <a href="{{ route('notifications.index') }}"
                           class="ws-btn-primary !w-full">
                            Check Notifications
                        </a>

                        <a href="{{ route('customer.repair-requests.index') }}"
                           class="ws-btn-secondary !w-full">
                            View Repair History
                        </a>
                    </div>
                </div>
            </div>

            {{-- Latest Repair Requests --}}
            <div class="ws-card overflow-hidden border border-slate-300">
                <div class="px-6 py-5 bg-slate-900 text-white flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div>
                        <h3 class="text-xl font-extrabold">
                            Latest Repair Requests
                        </h3>

                        <p class="text-sm text-slate-300 mt-1">
                            Your most recent repair request activity.
                        </p>
                    </div>

                    <a href="{{ route('customer.repair-requests.index') }}"
                       class="inline-flex items-center justify-center px-4 py-2 rounded-xl bg-white text-slate-900 text-sm font-extrabold hover:bg-blue-50">
                        View All Repairs
                    </a>
                </div>

                <div class="overflow-x-auto bg-white">
                    <table class="min-w-full text-sm">
                        <thead class="bg-slate-800 text-white">
                            <tr>
                                <th class="px-5 py-4 text-left font-extrabold">Repair Code</th>
                                <th class="px-5 py-4 text-left font-extrabold">Device</th>
                                <th class="px-5 py-4 text-left font-extrabold">Technician</th>
                                <th class="px-5 py-4 text-left font-extrabold">Status</th>
                                <th class="px-5 py-4 text-left font-extrabold">Invoice</th>
                                <th class="px-5 py-4 text-left font-extrabold">Action</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-200">
                            @forelse ($latestRepairRequests as $repairRequest)
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="px-5 py-4 font-extrabold text-slate-900 whitespace-nowrap">
                                        {{ $repairRequest->repair_code }}
                                    </td>

                                    <td class="px-5 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-2xl bg-blue-100 text-blue-700 flex items-center justify-center text-lg">
                                                @php
                                                    $deviceType = strtolower($repairRequest->device?->device_type ?? '');
                                                @endphp

                                                @if (str_contains($deviceType, 'phone'))
                                                    📱
                                                @elseif (str_contains($deviceType, 'laptop'))
                                                    🖥️
                                                @else
                                                    💻
                                                @endif
                                            </div>

                                            <div>
                                                <p class="font-extrabold text-slate-900">
                                                    {{ $repairRequest->device?->brand ?? '-' }}
                                                    {{ $repairRequest->device?->model ?? '' }}
                                                </p>
                                                <p class="text-xs font-semibold text-slate-400">
                                                    {{ $repairRequest->device?->device_type ?? 'Device' }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-5 py-4">
                                        @if ($repairRequest->technician)
                                            <p class="font-extrabold text-slate-900">
                                                {{ $repairRequest->technician?->user?->name }}
                                            </p>
                                            <p class="text-xs font-semibold text-slate-400">
                                                Assigned Technician
                                            </p>
                                        @else
                                            <span class="inline-flex px-3 py-1 rounded-full bg-slate-200 text-slate-700 text-xs font-extrabold">
                                                Not Assigned
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-5 py-4">
                                        <span class="ws-badge ws-status-{{ str_replace('_', '-', $repairRequest->status) }}">
                                            {{ ucwords(str_replace('_', ' ', $repairRequest->status)) }}
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
                                        <div class="flex flex-wrap gap-2">
                                            <a href="{{ route('customer.repair-requests.show', $repairRequest) }}"
                                               class="inline-flex items-center px-3 py-2 rounded-xl bg-blue-50 text-blue-700 text-xs font-extrabold hover:bg-blue-600 hover:text-white transition">
                                                View
                                            </a>

                                            @if ($repairRequest->invoice)
                                                <a href="{{ route('customer.invoices.show', $repairRequest->invoice) }}"
                                                   class="inline-flex items-center px-3 py-2 rounded-xl bg-green-50 text-green-700 text-xs font-extrabold hover:bg-green-600 hover:text-white transition">
                                                    Invoice
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-5 py-8 text-center text-slate-500">
                                        No repair requests found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>