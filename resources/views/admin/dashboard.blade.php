<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1">
            <h2 class="font-extrabold text-2xl text-slate-900 leading-tight">
                Admin Dashboard
            </h2>
            <p class="text-sm text-slate-500">
                A focused view of repair operations, billing, stock alerts, and recent workshop activity.
            </p>
        </div>
    </x-slot>

    @php
        $readyForInvoiceCount = \App\Models\RepairRequest::query()
            ->where('status', 'repair_completed')
            ->doesntHave('invoice')
            ->count();

        $quickActions = [
            [
                'title' => 'Repair Requests',
                'description' => 'Review new jobs and assignments.',
                'route' => route('admin.repair-requests.index'),
                'icon' => '🧾',
                'badge' => \App\Models\RepairRequest::where('status', 'submitted')->count(),
            ],
            [
                'title' => 'Invoices',
                'description' => 'Generate invoices for repair-completed jobs.',
                'route' => route('admin.invoices.index'),
                'icon' => '📄',
                'badge' => $readyForInvoiceCount,
            ],
            [
                'title' => 'Payments',
                'description' => 'Monitor unpaid invoices and receipts.',
                'route' => route('admin.payments.index'),
                'icon' => '💳',
                'badge' => $summary['unpaid_invoices'],
            ],
            [
                'title' => 'Reports',
                'description' => 'Review performance and workshop trends.',
                'route' => route('admin.reports.index'),
                'icon' => '📊',
                'badge' => 0,
            ],
        ];

        $metrics = [
            [
                'label' => 'Pending Repairs',
                'value' => $summary['pending_repairs'],
                'counter' => $summary['pending_repairs'],
                'description' => 'Requests currently in progress',
                'icon' => '⏳',
                'tone' => 'text-orange-600 bg-orange-50',
            ],
            [
                'label' => 'Ready for Invoice',
                'value' => $readyForInvoiceCount,
                'counter' => $readyForInvoiceCount,
                'description' => 'Repair-completed jobs without invoice',
                'icon' => '🧾',
                'tone' => 'text-indigo-600 bg-indigo-50',
            ],
            [
                'label' => 'Unpaid Invoices',
                'value' => $summary['unpaid_invoices'],
                'counter' => $summary['unpaid_invoices'],
                'description' => 'Waiting for customer payment',
                'icon' => '📄',
                'tone' => 'text-red-600 bg-red-50',
            ],
            [
                'label' => 'Payments Received',
                'value' => 'RM ' . number_format($summary['total_payments'], 2),
                'counter' => (float) $summary['total_payments'],
                'prefix' => 'RM ',
                'decimals' => 2,
                'description' => 'Total successful payments',
                'icon' => '💰',
                'tone' => 'text-emerald-600 bg-emerald-50',
            ],
            [
                'label' => 'Low Stock Parts',
                'value' => $summary['low_stock_parts'],
                'counter' => $summary['low_stock_parts'],
                'description' => 'Parts at or below threshold',
                'icon' => '⚠️',
                'tone' => 'text-amber-600 bg-amber-50',
            ],
            [
                'label' => 'Completed Repairs',
                'value' => $summary['completed_repairs'],
                'counter' => $summary['completed_repairs'],
                'description' => 'Jobs marked completed',
                'icon' => '✅',
                'tone' => 'text-green-600 bg-green-50',
            ],
        ];
    @endphp

    <div class="py-6 bg-slate-50 ws-dashboard">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-7">

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

            {{-- Header --}}
            <section class="ws-card p-6" data-gsap="hero">
                <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
                    <div class="max-w-3xl">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-slate-100 text-slate-600 text-xs font-extrabold">
                            <span>🛠️</span>
                            Workshop Control
                        </div>

                        <h3 class="mt-3 text-2xl font-extrabold text-slate-900 tracking-tight">
                            Admin Dashboard
                        </h3>

                        <p class="mt-2 text-sm text-slate-600 leading-relaxed">
                            Track the work that needs attention today: new repair requests, invoice readiness,
                            payment follow-up, stock alerts, and recent workshop activity.
                        </p>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3">
                        <a href="{{ route('admin.repair-requests.index') }}" class="ws-btn-primary !w-auto">
                            Manage Repair Requests
                        </a>

                        <a href="{{ route('admin.reports.index') }}" class="ws-btn-secondary !w-auto">
                            View Reports
                        </a>
                    </div>
                </div>
            </section>

            {{-- Quick Actions --}}
            <section class="space-y-4" data-gsap="fade-up">
                <div>
                    <h3 class="text-lg font-extrabold text-slate-900">Quick Actions</h3>
                    <p class="text-sm text-slate-500">Open the main admin workflows that usually need attention.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4" data-gsap-stagger>
                    @foreach ($quickActions as $action)
                        <a href="{{ $action['route'] }}" class="ws-card p-4 ws-hover-lift group" data-gsap-item>
                            <div class="flex items-start justify-between gap-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center text-xl">
                                        {{ $action['icon'] }}
                                    </div>

                                    <div>
                                        <h4 class="font-extrabold text-slate-900">{{ $action['title'] }}</h4>
                                        <p class="mt-0.5 text-xs text-slate-500">{{ $action['description'] }}</p>
                                    </div>
                                </div>

                                @if ($action['badge'] > 0)
                                    <span class="min-w-6 h-6 px-2 rounded-full bg-red-600 text-white text-xs flex items-center justify-center font-extrabold">
                                        {{ $action['badge'] }}
                                    </span>
                                @endif
                            </div>

                            <div class="mt-3 text-xs font-extrabold text-blue-600 group-hover:translate-x-1 transition">
                                Open →
                            </div>
                        </a>
                    @endforeach
                </div>
            </section>

            {{-- Operational Summary --}}
            <section class="space-y-4" data-gsap="fade-up">
                <div>
                    <h3 class="text-lg font-extrabold text-slate-900">Operational Summary</h3>
                    <p class="text-sm text-slate-500">The six most important workshop health indicators.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4" data-gsap-stagger>
                    @foreach ($metrics as $metric)
                        <div class="ws-card p-4" data-gsap-item>
                            <div class="flex items-center justify-between gap-3">
                                <p class="text-xs font-extrabold uppercase text-slate-500">{{ $metric['label'] }}</p>
                                <div class="w-9 h-9 rounded-xl {{ $metric['tone'] }} flex items-center justify-center">
                                    {{ $metric['icon'] }}
                                </div>
                            </div>

                            <p class="mt-3 text-2xl font-extrabold text-slate-900 break-words ws-counter"
                                data-gsap-counter="{{ $metric['counter'] }}"
                                data-gsap-final="{{ $metric['value'] }}"
                                data-gsap-prefix="{{ $metric['prefix'] ?? '' }}"
                                data-gsap-decimals="{{ $metric['decimals'] ?? 0 }}">
                                {{ $metric['value'] }}
                            </p>

                            <p class="mt-1 text-xs text-slate-500">
                                {{ $metric['description'] }}
                            </p>
                        </div>
                    @endforeach
                </div>
            </section>

            {{-- Sales Analytics --}}
            <section class="space-y-4" data-gsap="fade-up">
                <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <h3 class="text-lg font-extrabold text-slate-900">Sales Analytics</h3>
                        <p class="text-sm text-slate-500">Monthly paid payment performance for the current year.</p>
                    </div>

                    <span class="inline-flex w-fit rounded-full bg-slate-900 px-3 py-1.5 text-xs font-extrabold text-white">
                        {{ $salesAnalytics['unpaid_invoices'] }} unpaid invoices
                    </span>
                </div>

                <div class="grid grid-cols-1 xl:grid-cols-2 gap-4">
                    <div class="ws-card p-5" data-gsap="scale-in">
                        <div class="flex items-center justify-between gap-3">
                            <div>
                                <h4 class="font-extrabold text-slate-900">Monthly Sales</h4>
                                <p class="text-xs text-slate-500">Paid payment value by month.</p>
                            </div>
                            <p class="text-sm font-extrabold text-blue-600">
                                RM {{ number_format($salesAnalytics['sales_this_year'], 2) }}
                            </p>
                        </div>

                        <div class="mt-4 h-64">
                            <canvas id="monthlySalesChart"></canvas>
                        </div>
                    </div>

                    <div class="ws-card p-5" data-gsap="scale-in" data-gsap-delay="0.06">
                        <div class="flex items-center justify-between gap-3">
                            <div>
                                <h4 class="font-extrabold text-slate-900">Monthly Payment Count</h4>
                                <p class="text-xs text-slate-500">Successful payments by month.</p>
                            </div>
                            <p class="text-sm font-extrabold text-green-600">
                                {{ $salesAnalytics['paid_invoices_this_month'] }} paid this month
                            </p>
                        </div>

                        <div class="mt-4 h-64">
                            <canvas id="monthlyPaymentsChart"></canvas>
                        </div>
                    </div>
                </div>
            </section>

            {{-- Recent Repair Requests --}}
            <section class="ws-card overflow-hidden" data-gsap="fade-up">
                <div class="px-5 py-4 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div>
                        <h3 class="text-lg font-extrabold text-slate-900">Recent Repair Requests</h3>
                        <p class="text-sm text-slate-500">Latest repair jobs submitted by customers.</p>
                    </div>

                    <a href="{{ route('admin.repair-requests.index') }}" class="ws-btn-secondary !w-auto !py-2">
                        View All Requests
                    </a>
                </div>

                <div class="overflow-x-auto bg-white">
                    <table class="min-w-full text-sm">
                        <thead class="bg-slate-100 text-slate-600">
                            <tr>
                                <th class="px-5 py-3 text-left font-extrabold">Reference</th>
                                <th class="px-5 py-3 text-left font-extrabold">Customer</th>
                                <th class="px-5 py-3 text-left font-extrabold">Device</th>
                                <th class="px-5 py-3 text-left font-extrabold">Status</th>
                                <th class="px-5 py-3 text-left font-extrabold">Submitted</th>
                                <th class="px-5 py-3 text-left font-extrabold">Action</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-200">
                            @forelse ($recentRepairRequests as $repairRequest)
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="px-5 py-4 font-extrabold text-slate-900 whitespace-nowrap">
                                        {{ $repairRequest->repair_code }}
                                    </td>

                                    <td class="px-5 py-4">
                                        {{ $repairRequest->customer?->user?->name ?? '-' }}
                                    </td>

                                    <td class="px-5 py-4">
                                        <p class="font-semibold text-slate-900">
                                            {{ $repairRequest->device?->brand ?? '-' }}
                                            {{ $repairRequest->device?->model ?? '' }}
                                        </p>
                                        <p class="text-xs text-slate-500">
                                            {{ $repairRequest->device?->device_type ?? 'Device' }}
                                        </p>
                                    </td>

                                    <td class="px-5 py-4">
                                        <span class="ws-badge ws-status-{{ str_replace('_', '-', $repairRequest->status) }}">
                                            {{ ucwords(str_replace('_', ' ', $repairRequest->status)) }}
                                        </span>
                                    </td>

                                    <td class="px-5 py-4 whitespace-nowrap">
                                        {{ $repairRequest->request_date ? $repairRequest->request_date->format('d M Y') : '-' }}
                                    </td>

                                    <td class="px-5 py-4 whitespace-nowrap">
                                        <a href="{{ route('admin.repair-requests.show', $repairRequest) }}"
                                            class="inline-flex items-center px-3 py-2 rounded-xl bg-blue-50 text-blue-700 text-xs font-extrabold hover:bg-blue-600 hover:text-white transition">
                                            View
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-5 py-8 text-center text-slate-500">
                                        No recent repair requests found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const monthlySalesLabels = @json($monthlySalesLabels);
            const monthlySalesData = @json($monthlySalesData);
            const monthlyPaymentCounts = @json($monthlyPaymentCounts);

            const salesCanvas = document.getElementById('monthlySalesChart');
            const paymentsCanvas = document.getElementById('monthlyPaymentsChart');

            if (salesCanvas) {
                new Chart(salesCanvas, {
                    type: 'bar',
                    data: {
                        labels: monthlySalesLabels,
                        datasets: [{
                            label: 'Monthly Sales',
                            data: monthlySalesData,
                            backgroundColor: 'rgba(37, 99, 235, 0.78)',
                            borderColor: 'rgb(29, 78, 216)',
                            borderWidth: 1,
                            borderRadius: 6,
                            maxBarThickness: 42,
                        }],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false,
                            },
                            tooltip: {
                                callbacks: {
                                    label: function (context) {
                                        const value = Number(context.parsed.y || 0);

                                        return 'Sales: RM ' + value.toLocaleString('en-MY', {
                                            minimumFractionDigits: 2,
                                            maximumFractionDigits: 2,
                                        });
                                    },
                                },
                            },
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function (value) {
                                        return 'RM ' + Number(value).toLocaleString('en-MY');
                                    },
                                },
                                grid: {
                                    color: 'rgba(148, 163, 184, 0.25)',
                                },
                            },
                            x: {
                                grid: {
                                    display: false,
                                },
                            },
                        },
                    },
                });
            }

            if (paymentsCanvas) {
                new Chart(paymentsCanvas, {
                    type: 'line',
                    data: {
                        labels: monthlySalesLabels,
                        datasets: [{
                            label: 'Payment Count',
                            data: monthlyPaymentCounts,
                            borderColor: 'rgb(22, 163, 74)',
                            backgroundColor: 'rgba(22, 163, 74, 0.14)',
                            borderWidth: 3,
                            fill: true,
                            pointBackgroundColor: 'rgb(22, 163, 74)',
                            pointBorderColor: '#ffffff',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            tension: 0.35,
                        }],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false,
                            },
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    precision: 0,
                                },
                                grid: {
                                    color: 'rgba(148, 163, 184, 0.25)',
                                },
                            },
                            x: {
                                grid: {
                                    display: false,
                                },
                            },
                        },
                    },
                });
            }
        });
    </script>
</x-app-layout>
