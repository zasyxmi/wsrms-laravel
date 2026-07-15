@php
    $user = auth()->user();

    $unreadNotificationsCount = 0;

    if ($user && $user->role !== 'admin') {
        $unreadNotificationsCount = \App\Models\SystemNotification::query()
            ->where('user_id', $user->id)
            ->whereNull('read_at')
            ->count();
    }
@endphp

<nav x-data="{ open: false }" @keydown.escape.window="open = false">
    {{-- Mobile Top Navigation --}}
    <div class="lg:hidden bg-white/95 backdrop-blur border-b border-slate-200 sticky top-0 z-50">
        <div class="px-4 h-16 flex items-center justify-between">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-blue-600 to-sky-400 text-white flex items-center justify-center shadow-lg">
                    <span class="text-xl">🛠️</span>
                </div>

                <div>
                    <div class="text-lg font-extrabold text-slate-900">
                        WSRMS
                    </div>
                    <div class="text-xs font-semibold text-slate-500 -mt-1">
                        Workshop Repair System
                    </div>
                </div>
            </a>

            <button @click="open = ! open"
                    :aria-expanded="open.toString()"
                    aria-controls="mobile-sidebar-menu"
                    class="p-2 rounded-xl text-slate-600 hover:bg-slate-100 ws-transition ws-focus-ring">
                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path :class="{ 'hidden': open, 'inline-flex': !open }"
                          class="inline-flex"
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M4 6h16M4 12h16M4 18h16" />

                    <path :class="{ 'hidden': !open, 'inline-flex': open }"
                          class="hidden"
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        {{-- Mobile Dropdown Menu --}}
        <div x-cloak
             x-show="open"
             x-transition.opacity
             @click.outside="open = false"
             id="mobile-sidebar-menu"
             class="border-t border-slate-200 bg-white px-4 py-4 space-y-2">

            <a href="{{ route('dashboard') }}"
               class="block px-4 py-3 rounded-xl text-sm font-bold {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white' : 'text-slate-700 hover:bg-blue-50' }}">
                Dashboard
            </a>

            @if ($user->role !== 'admin' && Route::has('notifications.index'))
                <a href="{{ route('notifications.index') }}"
                   class="block px-4 py-3 rounded-xl text-sm font-bold {{ request()->routeIs('notifications.*') ? 'bg-blue-600 text-white' : 'text-slate-700 hover:bg-blue-50' }}">
                    Notifications

                    @if ($unreadNotificationsCount > 0)
                        <span class="ml-2 px-2 py-0.5 rounded-full bg-red-600 text-white text-xs">
                            {{ $unreadNotificationsCount }}
                        </span>
                    @endif
                </a>
            @endif

            @if ($user->role === 'admin')
                @if (Route::has('admin.repair-requests.index'))
                    <a href="{{ route('admin.repair-requests.index') }}"
                       class="flex items-center justify-between gap-3 px-4 py-3 rounded-xl text-sm font-bold {{ request()->routeIs('admin.repair-requests.*') ? 'bg-blue-600 text-white' : 'text-slate-700 hover:bg-blue-50' }}">
                        <span>Repair Requests</span>

                        @if (($adminRepairRequestsBadgeCount ?? 0) > 0)
                            <span class="min-w-6 h-6 px-2 rounded-full bg-red-600 text-white text-xs flex items-center justify-center">
                                {{ $adminRepairRequestsBadgeCount }}
                            </span>
                        @endif
                    </a>
                @endif

                @if (Route::has('admin.customers.index'))
                    <a href="{{ route('admin.customers.index') }}"
                       class="block px-4 py-3 rounded-xl text-sm font-bold {{ request()->routeIs('admin.customers.*') ? 'bg-blue-600 text-white' : 'text-slate-700 hover:bg-blue-50' }}">
                        Customers
                    </a>
                @endif

                @if (Route::has('admin.devices.index'))
                    <a href="{{ route('admin.devices.index') }}"
                       class="block px-4 py-3 rounded-xl text-sm font-bold {{ request()->routeIs('admin.devices.*') ? 'bg-blue-600 text-white' : 'text-slate-700 hover:bg-blue-50' }}">
                        Devices
                    </a>
                @endif

                @if (Route::has('admin.technicians.index'))
                    <a href="{{ route('admin.technicians.index') }}"
                       class="block px-4 py-3 rounded-xl text-sm font-bold {{ request()->routeIs('admin.technicians.*') ? 'bg-blue-600 text-white' : 'text-slate-700 hover:bg-blue-50' }}">
                        Technicians
                    </a>
                @endif

                @if (Route::has('admin.spare-parts.index'))
                    <a href="{{ route('admin.spare-parts.index') }}"
                       class="flex items-center justify-between gap-3 px-4 py-3 rounded-xl text-sm font-bold {{ request()->routeIs('admin.spare-parts.*') ? 'bg-blue-600 text-white' : 'text-slate-700 hover:bg-blue-50' }}">
                        <span>Spare Parts</span>

                        @if (($adminSparePartsBadgeCount ?? 0) > 0)
                            <span class="min-w-6 h-6 px-2 rounded-full bg-red-600 text-white text-xs flex items-center justify-center">
                                {{ $adminSparePartsBadgeCount }}
                            </span>
                        @endif
                    </a>
                @endif

                @if (Route::has('admin.invoices.index'))
                    <a href="{{ route('admin.invoices.index') }}"
                       class="flex items-center justify-between gap-3 px-4 py-3 rounded-xl text-sm font-bold {{ request()->routeIs('admin.invoices.*') ? 'bg-blue-600 text-white' : 'text-slate-700 hover:bg-blue-50' }}">
                        <span>Invoices</span>

                        @if (($adminInvoicesBadgeCount ?? 0) > 0)
                            <span class="min-w-6 h-6 px-2 rounded-full bg-red-600 text-white text-xs flex items-center justify-center">
                                {{ $adminInvoicesBadgeCount }}
                            </span>
                        @endif
                    </a>
                @endif

                @if (Route::has('admin.payments.index'))
                    <a href="{{ route('admin.payments.index') }}"
                       class="flex items-center justify-between gap-3 px-4 py-3 rounded-xl text-sm font-bold {{ request()->routeIs('admin.payments.*') ? 'bg-blue-600 text-white' : 'text-slate-700 hover:bg-blue-50' }}">
                        <span>Payments</span>

                        @if (($adminPaymentsBadgeCount ?? 0) > 0)
                            <span class="min-w-6 h-6 px-2 rounded-full bg-red-600 text-white text-xs flex items-center justify-center">
                                {{ $adminPaymentsBadgeCount }}
                            </span>
                        @endif
                    </a>
                @endif

                @if (Route::has('admin.reports.index'))
                    <a href="{{ route('admin.reports.index') }}"
                       class="block px-4 py-3 rounded-xl text-sm font-bold {{ request()->routeIs('admin.reports.*') ? 'bg-blue-600 text-white' : 'text-slate-700 hover:bg-blue-50' }}">
                        Reports
                    </a>
                @endif
            @endif

            @if ($user->role === 'customer')
                @if (Route::has('customer.repair-requests.create'))
                    <a href="{{ route('customer.repair-requests.create') }}"
                       class="block px-4 py-3 rounded-xl text-sm font-bold {{ request()->routeIs('customer.repair-requests.create') ? 'bg-blue-600 text-white' : 'text-slate-700 hover:bg-blue-50' }}">
                        Submit Request
                    </a>
                @endif

                @if (Route::has('customer.repair-requests.index'))
                    <a href="{{ route('customer.repair-requests.index') }}"
                       class="block px-4 py-3 rounded-xl text-sm font-bold {{ request()->routeIs('customer.repair-requests.*') && ! request()->routeIs('customer.repair-requests.create') ? 'bg-blue-600 text-white' : 'text-slate-700 hover:bg-blue-50' }}">
                        My Repairs
                    </a>
                @endif
            @endif

            @if ($user->role === 'technician')
                @if (Route::has('technician.repair-tasks.index'))
                    <a href="{{ route('technician.repair-tasks.index') }}"
                       class="block px-4 py-3 rounded-xl text-sm font-bold {{ request()->routeIs('technician.repair-tasks.*') ? 'bg-blue-600 text-white' : 'text-slate-700 hover:bg-blue-50' }}">
                        Repair Tasks
                    </a>
                @endif
            @endif

            <div class="pt-4 mt-4 border-t border-slate-200">
                <div class="px-4 py-2">
                    <p class="font-bold text-sm text-slate-900">
                        {{ $user->name }}
                    </p>
                    <p class="text-xs text-slate-500 capitalize">
                        {{ $user->email }} · {{ $user->role }}
                    </p>
                </div>

                @if (Route::has('profile.edit'))
                    <a href="{{ route('profile.edit') }}"
                       class="block px-4 py-3 rounded-xl text-sm font-bold text-slate-700 hover:bg-blue-50">
                        Profile
                    </a>
                @endif

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button type="submit"
                            class="w-full text-left px-4 py-3 rounded-xl text-sm font-bold text-red-600 hover:bg-red-50">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Desktop Sidebar --}}
    <aside class="hidden lg:flex fixed inset-y-0 left-0 z-50 w-72 bg-white/95 backdrop-blur border-r border-slate-200 shadow-xl shadow-slate-200/60 flex-col">
        {{-- Logo --}}
        <div class="h-24 px-6 flex items-center border-b border-slate-200">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-blue-600 to-sky-400 text-white flex items-center justify-center shadow-lg shadow-blue-200">
                    <span class="text-2xl">🛠️</span>
                </div>

                <div>
                    <div class="text-2xl font-extrabold tracking-tight text-slate-900">
                        WSRMS
                    </div>
                    <div class="text-xs font-bold text-slate-500 -mt-1">
                        Workshop Repair System
                    </div>
                </div>
            </a>
        </div>

        {{-- Menu --}}
        <div class="flex-1 overflow-y-auto px-4 py-6">
            <div class="mb-5">
                <p class="px-3 text-xs font-extrabold uppercase tracking-wider text-slate-400">
                    Main Menu
                </p>
            </div>

            <div class="space-y-2">
                <a href="{{ route('dashboard') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-extrabold transition {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white shadow-lg shadow-blue-200' : 'text-slate-600 hover:bg-blue-50 hover:text-blue-700' }}">
                    <span class="text-lg">🏠</span>
                    <span>Dashboard</span>
                </a>

                @if ($user->role !== 'admin' && Route::has('notifications.index'))
                    <a href="{{ route('notifications.index') }}"
                       class="relative flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-extrabold transition {{ request()->routeIs('notifications.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-200' : 'text-slate-600 hover:bg-blue-50 hover:text-blue-700' }}">
                        <span class="text-lg">🔔</span>
                        <span>Notifications</span>

                        @if ($unreadNotificationsCount > 0)
                            <span class="ml-auto min-w-6 h-6 px-2 rounded-full bg-red-600 text-white text-xs flex items-center justify-center">
                                {{ $unreadNotificationsCount }}
                            </span>
                        @endif
                    </a>
                @endif

                @if ($user->role === 'admin')
                    @if (Route::has('admin.repair-requests.index'))
                        <a href="{{ route('admin.repair-requests.index') }}"
                           class="flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-extrabold transition {{ request()->routeIs('admin.repair-requests.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-200' : 'text-slate-600 hover:bg-blue-50 hover:text-blue-700' }}">
                            <span class="text-lg">🧾</span>
                            <span>Repair Requests</span>

                            @if (($adminRepairRequestsBadgeCount ?? 0) > 0)
                                <span class="ml-auto min-w-6 h-6 px-2 rounded-full bg-red-600 text-white text-xs flex items-center justify-center">
                                    {{ $adminRepairRequestsBadgeCount }}
                                </span>
                            @endif
                        </a>
                    @endif

                    @if (Route::has('admin.customers.index'))
                        <a href="{{ route('admin.customers.index') }}"
                           class="flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-extrabold transition {{ request()->routeIs('admin.customers.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-200' : 'text-slate-600 hover:bg-blue-50 hover:text-blue-700' }}">
                            <span class="text-lg">👥</span>
                            <span>Customers</span>
                        </a>
                    @endif

                    @if (Route::has('admin.devices.index'))
                        <a href="{{ route('admin.devices.index') }}"
                           class="flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-extrabold transition {{ request()->routeIs('admin.devices.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-200' : 'text-slate-600 hover:bg-blue-50 hover:text-blue-700' }}">
                            <span class="text-lg">💻</span>
                            <span>Devices</span>
                        </a>
                    @endif

                    @if (Route::has('admin.technicians.index'))
                        <a href="{{ route('admin.technicians.index') }}"
                           class="flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-extrabold transition {{ request()->routeIs('admin.technicians.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-200' : 'text-slate-600 hover:bg-blue-50 hover:text-blue-700' }}">
                            <span class="text-lg">🛠️</span>
                            <span>Technicians</span>
                        </a>
                    @endif

                    @if (Route::has('admin.spare-parts.index'))
                        <a href="{{ route('admin.spare-parts.index') }}"
                           class="flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-extrabold transition {{ request()->routeIs('admin.spare-parts.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-200' : 'text-slate-600 hover:bg-blue-50 hover:text-blue-700' }}">
                            <span class="text-lg">📦</span>
                            <span>Spare Parts</span>

                            @if (($adminSparePartsBadgeCount ?? 0) > 0)
                                <span class="ml-auto min-w-6 h-6 px-2 rounded-full bg-red-600 text-white text-xs flex items-center justify-center">
                                    {{ $adminSparePartsBadgeCount }}
                                </span>
                            @endif
                        </a>
                    @endif

                    @if (Route::has('admin.invoices.index'))
                        <a href="{{ route('admin.invoices.index') }}"
                           class="flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-extrabold transition {{ request()->routeIs('admin.invoices.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-200' : 'text-slate-600 hover:bg-blue-50 hover:text-blue-700' }}">
                            <span class="text-lg">📄</span>
                            <span>Invoices</span>

                            @if (($adminInvoicesBadgeCount ?? 0) > 0)
                                <span class="ml-auto min-w-6 h-6 px-2 rounded-full bg-red-600 text-white text-xs flex items-center justify-center">
                                    {{ $adminInvoicesBadgeCount }}
                                </span>
                            @endif
                        </a>
                    @endif

                    @if (Route::has('admin.payments.index'))
                        <a href="{{ route('admin.payments.index') }}"
                           class="flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-extrabold transition {{ request()->routeIs('admin.payments.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-200' : 'text-slate-600 hover:bg-blue-50 hover:text-blue-700' }}">
                            <span class="text-lg">💳</span>
                            <span>Payments</span>

                            @if (($adminPaymentsBadgeCount ?? 0) > 0)
                                <span class="ml-auto min-w-6 h-6 px-2 rounded-full bg-red-600 text-white text-xs flex items-center justify-center">
                                    {{ $adminPaymentsBadgeCount }}
                                </span>
                            @endif
                        </a>
                    @endif

                    @if (Route::has('admin.reports.index'))
                        <a href="{{ route('admin.reports.index') }}"
                           class="flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-extrabold transition {{ request()->routeIs('admin.reports.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-200' : 'text-slate-600 hover:bg-blue-50 hover:text-blue-700' }}">
                            <span class="text-lg">📊</span>
                            <span>Reports</span>
                        </a>
                    @endif
                @endif

                @if ($user->role === 'customer')
                    @if (Route::has('customer.repair-requests.create'))
                        <a href="{{ route('customer.repair-requests.create') }}"
                           class="flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-extrabold transition {{ request()->routeIs('customer.repair-requests.create') ? 'bg-blue-600 text-white shadow-lg shadow-blue-200' : 'text-slate-600 hover:bg-blue-50 hover:text-blue-700' }}">
                            <span class="text-lg">➕</span>
                            <span>Submit Request</span>
                        </a>
                    @endif

                    @if (Route::has('customer.repair-requests.index'))
                        <a href="{{ route('customer.repair-requests.index') }}"
                           class="flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-extrabold transition {{ request()->routeIs('customer.repair-requests.*') && ! request()->routeIs('customer.repair-requests.create') ? 'bg-blue-600 text-white shadow-lg shadow-blue-200' : 'text-slate-600 hover:bg-blue-50 hover:text-blue-700' }}">
                            <span class="text-lg">📋</span>
                            <span>My Repairs</span>
                        </a>
                    @endif
                @endif

                @if ($user->role === 'technician')
                    @if (Route::has('technician.repair-tasks.index'))
                        <a href="{{ route('technician.repair-tasks.index') }}"
                           class="flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-extrabold transition {{ request()->routeIs('technician.repair-tasks.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-200' : 'text-slate-600 hover:bg-blue-50 hover:text-blue-700' }}">
                            <span class="text-lg">🔧</span>
                            <span>Repair Tasks</span>
                        </a>
                    @endif
                @endif
            </div>

            {{-- Info Card --}}
            <div class="mt-8 ws-card p-4">
                <div class="flex items-center gap-2 text-sm font-extrabold">
                    <span class="text-green-600">🔒 Secure</span>
                    <span class="text-slate-300">•</span>
                    <span class="text-amber-600">Reliable</span>
                </div>

                <p class="mt-2 text-xs text-slate-500 leading-relaxed">
                    Manage PC, laptop, and handphone repairs with secure role-based access.
                </p>
            </div>
        </div>

        {{-- User Area --}}
        <div class="border-t border-slate-200 p-4">
            <div class="flex items-center gap-3 p-3 rounded-2xl bg-slate-50 border border-slate-200">
                <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-slate-900 to-blue-600 text-white flex items-center justify-center font-extrabold">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>

                <div class="min-w-0 flex-1">
                    <p class="font-extrabold text-sm text-slate-900 truncate">
                        {{ $user->name }}
                    </p>

                    <p class="text-xs text-slate-500 capitalize truncate">
                        {{ $user->role }}
                    </p>
                </div>
            </div>

            <div class="mt-3 grid grid-cols-2 gap-2">
                @if (Route::has('profile.edit'))
                    <a href="{{ route('profile.edit') }}"
                       class="text-center px-3 py-2 rounded-xl bg-white border border-slate-200 text-xs font-extrabold text-slate-600 hover:bg-blue-50 hover:text-blue-700">
                        Profile
                    </a>
                @endif

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button type="submit"
                            class="w-full text-center px-3 py-2 rounded-xl bg-red-50 border border-red-100 text-xs font-extrabold text-red-600 hover:bg-red-100">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </aside>
</nav>
