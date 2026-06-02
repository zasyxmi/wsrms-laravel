<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1">
            <h2 class="font-extrabold text-2xl text-slate-900 leading-tight">
                Admin Dashboard
            </h2>
            <p class="text-sm text-slate-500">
                Monitor repair requests, customers, technicians, invoices, payments, spare parts, and reports.
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
                        <div
                            class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 text-blue-700 text-sm font-extrabold mb-4">
                            <span>🛠️</span>
                            Workshop Control Center
                        </div>

                        <h3 class="text-3xl font-extrabold text-slate-900 tracking-tight">
                            Welcome back, Admin
                        </h3>

                        <p class="mt-3 text-slate-600 max-w-3xl leading-relaxed">
                            Manage the full repair workflow from customer request submission, technician assignment,
                            diagnosis, spare part usage, invoice generation, payment tracking, receipt download,
                            pickup notification, and management reports.
                        </p>

                        <div class="mt-6 flex flex-wrap gap-3">
                            <a href="{{ route('admin.repair-requests.index') }}" class="ws-btn-primary !w-auto">
                                Manage Repair Requests
                            </a>

                            <a href="{{ route('admin.reports.index') }}" class="ws-btn-secondary !w-auto">
                                View Reports
                            </a>

                            <a href="{{ route('admin.payments.index') }}" class="ws-btn-secondary !w-auto">
                                View Payments
                            </a>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-blue-600 to-sky-400 p-8 text-white flex flex-col justify-center">
                        <p class="text-sm font-bold text-blue-100">
                            Supported Repair Services
                        </p>

                        <div class="mt-5 space-y-4">
                            <div class="flex items-center gap-4 bg-white/15 rounded-2xl p-4 backdrop-blur">
                                <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center text-2xl">
                                    💻
                                </div>
                                <div>
                                    <p class="font-extrabold">PC Repair</p>
                                    <p class="text-sm text-blue-100">Hardware, software, and diagnostics.</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-4 bg-white/15 rounded-2xl p-4 backdrop-blur">
                                <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center text-2xl">
                                    🖥️
                                </div>
                                <div>
                                    <p class="font-extrabold">Laptop Repair</p>
                                    <p class="text-sm text-blue-100">Screen, battery, keyboard, and storage.</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-4 bg-white/15 rounded-2xl p-4 backdrop-blur">
                                <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center text-2xl">
                                    📱
                                </div>
                                <div>
                                    <p class="font-extrabold">Handphone Repair</p>
                                    <p class="text-sm text-blue-100">Screen, charging, battery, and more.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Quick Management Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                <a href="{{ route('admin.repair-requests.index') }}"
                    class="ws-card p-5 hover:-translate-y-1 transition duration-200 group">
                    <div class="flex items-center justify-between">
                        <div
                            class="w-12 h-12 rounded-2xl bg-blue-100 text-blue-700 flex items-center justify-center text-2xl">
                            🧾
                        </div>
                        <span class="text-xs font-extrabold text-blue-600 group-hover:translate-x-1 transition">
                            Open →
                        </span>
                    </div>
                    <h4 class="mt-4 font-extrabold text-slate-900">
                        Repair Requests
                    </h4>
                    <p class="mt-1 text-sm text-slate-500">
                        Approve, reject, and assign repair jobs.
                    </p>
                </a>

                <a href="{{ route('admin.customers.index') }}"
                    class="ws-card p-5 hover:-translate-y-1 transition duration-200 group">
                    <div class="flex items-center justify-between">
                        <div
                            class="w-12 h-12 rounded-2xl bg-green-100 text-green-700 flex items-center justify-center text-2xl">
                            👥
                        </div>
                        <span class="text-xs font-extrabold text-blue-600 group-hover:translate-x-1 transition">
                            Open →
                        </span>
                    </div>
                    <h4 class="mt-4 font-extrabold text-slate-900">
                        Customers
                    </h4>
                    <p class="mt-1 text-sm text-slate-500">
                        View customer records and repair history.
                    </p>
                </a>

                <a href="{{ route('admin.technicians.index') }}"
                    class="ws-card p-5 hover:-translate-y-1 transition duration-200 group">
                    <div class="flex items-center justify-between">
                        <div
                            class="w-12 h-12 rounded-2xl bg-amber-100 text-amber-700 flex items-center justify-center text-2xl">
                            🛠️
                        </div>
                        <span class="text-xs font-extrabold text-blue-600 group-hover:translate-x-1 transition">
                            Open →
                        </span>
                    </div>
                    <h4 class="mt-4 font-extrabold text-slate-900">
                        Technicians
                    </h4>
                    <p class="mt-1 text-sm text-slate-500">
                        Manage technician accounts and availability.
                    </p>
                </a>

                <a href="{{ route('admin.spare-parts.index') }}"
                    class="ws-card p-5 hover:-translate-y-1 transition duration-200 group">
                    <div class="flex items-center justify-between">
                        <div
                            class="w-12 h-12 rounded-2xl bg-purple-100 text-purple-700 flex items-center justify-center text-2xl">
                            📦
                        </div>
                        <span class="text-xs font-extrabold text-blue-600 group-hover:translate-x-1 transition">
                            Open →
                        </span>
                    </div>
                    <h4 class="mt-4 font-extrabold text-slate-900">
                        Spare Parts
                    </h4>
                    <p class="mt-1 text-sm text-slate-500">
                        Track stock, price, and low inventory items.
                    </p>
                </a>

                <a href="{{ route('admin.devices.index') }}"
                    class="ws-card p-5 hover:-translate-y-1 transition duration-200 group">
                    <div class="flex items-center justify-between">
                        <div
                            class="w-12 h-12 rounded-2xl bg-cyan-100 text-cyan-700 flex items-center justify-center text-2xl">
                            💻
                        </div>
                        <span class="text-xs font-extrabold text-blue-600 group-hover:translate-x-1 transition">
                            Open →
                        </span>
                    </div>
                    <h4 class="mt-4 font-extrabold text-slate-900">
                        Devices
                    </h4>
                    <p class="mt-1 text-sm text-slate-500">
                        View registered PC, laptop, and phone devices.
                    </p>
                </a>

                <a href="{{ route('admin.invoices.index') }}"
                    class="ws-card p-5 hover:-translate-y-1 transition duration-200 group">
                    <div class="flex items-center justify-between">
                        <div
                            class="w-12 h-12 rounded-2xl bg-indigo-100 text-indigo-700 flex items-center justify-center text-2xl">
                            📄
                        </div>
                        <span class="text-xs font-extrabold text-blue-600 group-hover:translate-x-1 transition">
                            Open →
                        </span>
                    </div>
                    <h4 class="mt-4 font-extrabold text-slate-900">
                        Invoices
                    </h4>
                    <p class="mt-1 text-sm text-slate-500">
                        Manage invoice records and payment status.
                    </p>
                </a>

                <a href="{{ route('admin.payments.index') }}"
                    class="ws-card p-5 hover:-translate-y-1 transition duration-200 group">
                    <div class="flex items-center justify-between">
                        <div
                            class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-2xl">
                            💳
                        </div>
                        <span class="text-xs font-extrabold text-blue-600 group-hover:translate-x-1 transition">
                            Open →
                        </span>
                    </div>
                    <h4 class="mt-4 font-extrabold text-slate-900">
                        Payments
                    </h4>
                    <p class="mt-1 text-sm text-slate-500">
                        Monitor paid invoices and receipt records.
                    </p>
                </a>

                <a href="{{ route('admin.reports.index') }}"
                    class="ws-card p-5 hover:-translate-y-1 transition duration-200 group">
                    <div class="flex items-center justify-between">
                        <div
                            class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-700 flex items-center justify-center text-2xl">
                            📊
                        </div>
                        <span class="text-xs font-extrabold text-blue-600 group-hover:translate-x-1 transition">
                            Open →
                        </span>
                    </div>
                    <h4 class="mt-4 font-extrabold text-slate-900">
                        Reports
                    </h4>
                    <p class="mt-1 text-sm text-slate-500">
                        View repair, payment, and stock summaries.
                    </p>
                </a>
            </div>

            {{-- Summary Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">
                <div class="ws-card p-6">
                    <div class="flex items-center justify-between">
                        <p class="text-sm font-bold text-slate-500">Total Customers</p>
                        <div class="w-10 h-10 rounded-2xl bg-blue-50 text-blue-700 flex items-center justify-center">
                            👥
                        </div>
                    </div>
                    <p class="mt-4 text-4xl font-extrabold text-slate-900">
                        {{ $summary['total_customers'] }}
                    </p>
                    <p class="mt-1 text-xs font-semibold text-slate-400">
                        Registered customer accounts
                    </p>
                </div>

                <div class="ws-card p-6">
                    <div class="flex items-center justify-between">
                        <p class="text-sm font-bold text-slate-500">Total Technicians</p>
                        <div class="w-10 h-10 rounded-2xl bg-amber-50 text-amber-700 flex items-center justify-center">
                            🛠️
                        </div>
                    </div>
                    <p class="mt-4 text-4xl font-extrabold text-slate-900">
                        {{ $summary['total_technicians'] }}
                    </p>
                    <p class="mt-1 text-xs font-semibold text-slate-400">
                        Active technician profiles
                    </p>
                </div>

                <div class="ws-card p-6">
                    <div class="flex items-center justify-between">
                        <p class="text-sm font-bold text-slate-500">Total Devices</p>
                        <div class="w-10 h-10 rounded-2xl bg-cyan-50 text-cyan-700 flex items-center justify-center">
                            💻
                        </div>
                    </div>
                    <p class="mt-4 text-4xl font-extrabold text-slate-900">
                        {{ $summary['total_devices'] }}
                    </p>
                    <p class="mt-1 text-xs font-semibold text-slate-400">
                        Customer registered devices
                    </p>
                </div>

                <div class="ws-card p-6">
                    <div class="flex items-center justify-between">
                        <p class="text-sm font-bold text-slate-500">Pending Repairs</p>
                        <div
                            class="w-10 h-10 rounded-2xl bg-orange-50 text-orange-700 flex items-center justify-center">
                            ⏳
                        </div>
                    </div>
                    <p class="mt-4 text-4xl font-extrabold text-orange-600">
                        {{ $summary['pending_repairs'] }}
                    </p>
                    <p class="mt-1 text-xs font-semibold text-slate-400">
                        Requests still in progress
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
                        Successfully completed repair jobs
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
                        Waiting for customer payment
                    </p>
                </div>

                <div class="ws-card p-6">
                    <div class="flex items-center justify-between">
                        <p class="text-sm font-bold text-slate-500">Payments Received</p>
                        <div
                            class="w-10 h-10 rounded-2xl bg-purple-50 text-purple-700 flex items-center justify-center">
                            💰
                        </div>
                    </div>
                    <p class="mt-4 text-3xl font-extrabold text-purple-600">
                        RM {{ number_format($summary['total_payments'], 2) }}
                    </p>
                    <p class="mt-1 text-xs font-semibold text-slate-400">
                        Total successful payments
                    </p>
                </div>

                <div class="ws-card p-6">
                    <div class="flex items-center justify-between">
                        <p class="text-sm font-bold text-slate-500">Low Stock Parts</p>
                        <div
                            class="w-10 h-10 rounded-2xl bg-yellow-50 text-yellow-700 flex items-center justify-center">
                            ⚠️
                        </div>
                    </div>
                    <p class="mt-4 text-4xl font-extrabold text-amber-600">
                        {{ $summary['low_stock_parts'] }}
                    </p>
                    <p class="mt-1 text-xs font-semibold text-slate-400">
                        Spare parts need attention
                    </p>
                </div>
            </div>

            {{-- Sales Analytics --}}
            <div class="space-y-5">
                <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <h3 class="text-2xl font-extrabold text-slate-900">
                            Sales Analytics
                        </h3>
                        <p class="text-sm text-slate-500">
                            Monthly paid payment performance for the current year.
                        </p>
                    </div>

                    <span class="inline-flex w-fit rounded-full bg-slate-900 px-4 py-2 text-xs font-extrabold text-white">
                        {{ $salesAnalytics['unpaid_invoices'] }} unpaid invoices
                    </span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">
                    <div class="ws-card p-6 border border-blue-100">
                        <p class="text-sm font-bold text-slate-500">
                            Total Sales This Month
                        </p>
                        <p class="mt-4 text-3xl font-extrabold text-blue-600">
                            RM {{ number_format($salesAnalytics['sales_this_month'], 2) }}
                        </p>
                        <p class="mt-1 text-xs font-semibold text-slate-400">
                            Paid payments received this month
                        </p>
                    </div>

                    <div class="ws-card p-6 border border-sky-100">
                        <p class="text-sm font-bold text-slate-500">
                            Total Sales This Year
                        </p>
                        <p class="mt-4 text-3xl font-extrabold text-sky-600">
                            RM {{ number_format($salesAnalytics['sales_this_year'], 2) }}
                        </p>
                        <p class="mt-1 text-xs font-semibold text-slate-400">
                            Paid payments received this year
                        </p>
                    </div>

                    <div class="ws-card p-6 border border-green-100">
                        <p class="text-sm font-bold text-slate-500">
                            Completed Repairs This Month
                        </p>
                        <p class="mt-4 text-4xl font-extrabold text-green-600">
                            {{ $salesAnalytics['completed_repairs_this_month'] }}
                        </p>
                        <p class="mt-1 text-xs font-semibold text-slate-400">
                            Jobs marked completed this month
                        </p>
                    </div>

                    <div class="ws-card p-6 border border-emerald-100">
                        <p class="text-sm font-bold text-slate-500">
                            Paid Invoices This Month
                        </p>
                        <p class="mt-4 text-4xl font-extrabold text-emerald-600">
                            {{ $salesAnalytics['paid_invoices_this_month'] }}
                        </p>
                        <p class="mt-1 text-xs font-semibold text-slate-400">
                            Invoices paid during this month
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 xl:grid-cols-2 gap-5">
                    <div class="ws-card overflow-hidden border border-slate-300">
                        <div class="px-6 py-4 bg-slate-900 text-white">
                            <h4 class="text-lg font-extrabold">
                                Monthly Sales Chart
                            </h4>
                            <p class="mt-1 text-sm text-slate-300">
                                Paid payment value by month.
                            </p>
                        </div>
                        <div class="p-6 bg-white">
                            <div class="h-80">
                                <canvas id="monthlySalesChart"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="ws-card overflow-hidden border border-slate-300">
                        <div class="px-6 py-4 bg-slate-900 text-white">
                            <h4 class="text-lg font-extrabold">
                                Monthly Payment Count Chart
                            </h4>
                            <p class="mt-1 text-sm text-slate-300">
                                Number of successful payments by month.
                            </p>
                        </div>
                        <div class="p-6 bg-white">
                            <div class="h-80">
                                <canvas id="monthlyPaymentsChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Recent Repair Requests --}}
            <div class="ws-card overflow-hidden border border-slate-300">
                <div
                    class="px-6 py-5 bg-slate-900 text-white flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div>
                        <h3 class="text-xl font-extrabold">
                            Recent Repair Requests
                        </h3>
                        <p class="text-sm text-slate-300 mt-1">
                            Latest repair jobs submitted by customers.
                        </p>
                    </div>

                    <a href="{{ route('admin.repair-requests.index') }}"
                        class="inline-flex items-center justify-center px-4 py-2 rounded-xl bg-white text-slate-900 text-sm font-extrabold hover:bg-blue-50">
                        View All Requests
                    </a>
                </div>

                <div class="overflow-x-auto bg-white">
                    <table class="min-w-full text-sm">
                        <thead class="bg-slate-800 text-white">
                            <tr>
                                <th class="px-5 py-4 text-left font-extrabold">Repair Code</th>
                                <th class="px-5 py-4 text-left font-extrabold">Customer</th>
                                <th class="px-5 py-4 text-left font-extrabold">Device</th>
                                <th class="px-5 py-4 text-left font-extrabold">Technician</th>
                                <th class="px-5 py-4 text-left font-extrabold">Status</th>
                                <th class="px-5 py-4 text-left font-extrabold">Action</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-200">
                            @forelse ($recentRepairRequests as $repairRequest)
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="px-5 py-4 font-extrabold text-slate-900 whitespace-nowrap">
                                        {{ $repairRequest->repair_code }}
                                    </td>

                                    <td class="px-5 py-4">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-10 h-10 rounded-2xl bg-blue-100 text-blue-700 flex items-center justify-center font-extrabold">
                                                {{ strtoupper(substr($repairRequest->customer?->user?->name ?? 'C', 0, 1)) }}
                                            </div>

                                            <div>
                                                <p class="font-extrabold text-slate-900">
                                                    {{ $repairRequest->customer?->user?->name ?? '-' }}
                                                </p>
                                                <p class="text-xs font-semibold text-slate-400">
                                                    Customer
                                                </p>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-5 py-4">
                                        <p class="font-extrabold text-slate-900">
                                            {{ $repairRequest->device?->brand ?? '-' }}
                                            {{ $repairRequest->device?->model ?? '' }}
                                        </p>
                                        <p class="text-xs font-semibold text-slate-400">
                                            {{ $repairRequest->device?->device_type ?? 'Device' }}
                                        </p>
                                    </td>

                                    <td class="px-5 py-4">
                                        @if ($repairRequest->technician)
                                            <p class="font-extrabold text-slate-900">
                                                {{ $repairRequest->technician?->user?->name }}
                                            </p>
                                            <p class="text-xs font-semibold text-slate-400">
                                                Technician
                                            </p>
                                        @else
                                            <span
                                                class="inline-flex px-3 py-1 rounded-full bg-slate-200 text-slate-700 text-xs font-extrabold">
                                                Not Assigned
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-5 py-4">
                                        <span
                                            class="ws-badge ws-status-{{ str_replace('_', '-', $repairRequest->status) }}">
                                            {{ ucwords(str_replace('_', ' ', $repairRequest->status)) }}
                                        </span>
                                    </td>

                                    <td class="px-5 py-4 whitespace-nowrap">
                                        <a href="{{ route('admin.repair-requests.show', $repairRequest) }}"
                                            class="inline-flex items-center px-3 py-2 rounded-xl bg-blue-50 text-blue-700 text-xs font-extrabold hover:bg-blue-600 hover:text-white transition">
                                            View Details
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
            </div>

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
