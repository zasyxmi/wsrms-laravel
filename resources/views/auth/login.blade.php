<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center px-6 py-10 bg-slate-100/40">
        <div class="w-full max-w-6xl grid grid-cols-1 lg:grid-cols-2 gap-8 items-stretch">

            <div class="ws-workshop-hero p-8 lg:p-10 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-72 h-72 bg-white/10 rounded-full blur-3xl translate-x-20 -translate-y-20"></div>
                <div class="absolute bottom-0 left-0 w-72 h-72 bg-amber-300/20 rounded-full blur-3xl -translate-x-20 translate-y-20"></div>

                <div class="relative z-10 h-full flex flex-col justify-between">
                    <div>
                        <div class="flex items-center gap-3 mb-10">
                            <div class="w-12 h-12 rounded-2xl bg-white/15 flex items-center justify-center shadow-lg">
                                <span class="text-2xl">🛠️</span>
                            </div>

                            <div>
                                <h1 class="text-2xl font-extrabold tracking-tight">
                                    WSRMS
                                </h1>
                                <p class="text-sm text-blue-100">
                                    Workshop Repair Service Management System
                                </p>
                            </div>
                        </div>

                        <h2 class="text-4xl lg:text-5xl font-extrabold leading-tight tracking-tight">
                            Smart repair tracking for
                            <span class="text-amber-300">PC, laptop & handphone.</span>
                        </h2>

                        <p class="mt-5 text-blue-50 text-lg leading-relaxed max-w-xl">
                            Manage repair requests, technician tasks, spare parts, invoices,
                            payments, receipts, pickup notifications, and reports in one system.
                        </p>
                    </div>

                    <div class="mt-10 grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div class="bg-white/12 border border-white/15 rounded-2xl p-4 backdrop-blur">
                            <div class="text-3xl mb-3">💻</div>
                            <p class="font-bold">PC Repair</p>
                            <p class="text-sm text-blue-100 mt-1">
                                Hardware, software, and diagnostics.
                            </p>
                        </div>

                        <div class="bg-white/12 border border-white/15 rounded-2xl p-4 backdrop-blur">
                            <div class="text-3xl mb-3">🖥️</div>
                            <p class="font-bold">Laptop Repair</p>
                            <p class="text-sm text-blue-100 mt-1">
                                Battery, screen, keyboard, and storage.
                            </p>
                        </div>

                        <div class="bg-white/12 border border-white/15 rounded-2xl p-4 backdrop-blur">
                            <div class="text-3xl mb-3">📱</div>
                            <p class="font-bold">Phone Repair</p>
                            <p class="text-sm text-blue-100 mt-1">
                                Screen, charging, battery, and more.
                            </p>
                        </div>
                    </div>

                    <div class="mt-10 bg-white/10 border border-white/15 rounded-2xl p-5 backdrop-blur">
                        <div class="grid grid-cols-3 gap-4 text-center">
                            <div>
                                <p class="text-2xl font-extrabold">3</p>
                                <p class="text-xs text-blue-100 mt-1">User Roles</p>
                            </div>

                            <div>
                                <p class="text-2xl font-extrabold">PDF</p>
                                <p class="text-xs text-blue-100 mt-1">Receipt Ready</p>
                            </div>

                            <div>
                                <p class="text-2xl font-extrabold">Email</p>
                                <p class="text-xs text-blue-100 mt-1">Pickup Alert</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="ws-card-soft p-8 lg:p-10 flex flex-col justify-center border-t-4 border-blue-600">
                <div class="mb-8">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 text-blue-700 text-sm font-bold mb-4">
                        <span>🔐</span>
                        Secure Login
                    </div>

                    <h2 class="ws-heading text-3xl">
                        Welcome Back
                    </h2>

                    <p class="ws-subtext mt-2">
                        Sign in to continue managing your repair workflow.
                    </p>
                </div>

                @if (session('status'))
                    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-xl">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label for="email" class="ws-label">
                            Email Address
                        </label>

                        <input id="email"
                               type="email"
                               name="email"
                               value="{{ old('email') }}"
                               required
                               autofocus
                               autocomplete="username"
                               placeholder="you@example.com"
                               class="ws-input">

                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="ws-label">
                            Password
                        </label>

                        <input id="password"
                               type="password"
                               name="password"
                               required
                               autocomplete="current-password"
                               placeholder="Enter your password"
                               class="ws-input">

                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me"
                                   type="checkbox"
                                   name="remember"
                                   class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">

                            <span class="ms-2 text-sm text-gray-600">
                                Remember me
                            </span>
                        </label>

                        @if (Route::has('password.request'))
                            <a class="text-sm font-semibold text-blue-600 hover:text-blue-800"
                               href="{{ route('password.request') }}">
                                Forgot password?
                            </a>
                        @endif
                    </div>

                    <button type="submit" class="ws-btn-primary w-full">
                        Sign In
                    </button>
                </form>

                <div class="my-8 flex items-center gap-4">
                    <div class="h-px bg-gray-200 flex-1"></div>
                    <p class="text-sm text-gray-500">New customer?</p>
                    <div class="h-px bg-gray-200 flex-1"></div>
                </div>

                <a href="{{ route('register') }}"
                   class="ws-btn-secondary w-full">
                    Create Customer Account
                </a>

                <div class="mt-8 grid grid-cols-1 sm:grid-cols-3 gap-3 text-center">
                    <div class="rounded-2xl bg-gray-50 border border-gray-100 p-3">
                        <p class="text-xl">📋</p>
                        <p class="text-xs font-bold text-gray-700 mt-1">Track Repairs</p>
                    </div>

                    <div class="rounded-2xl bg-gray-50 border border-gray-100 p-3">
                        <p class="text-xl">💳</p>
                        <p class="text-xs font-bold text-gray-700 mt-1">Invoices</p>
                    </div>

                    <div class="rounded-2xl bg-gray-50 border border-gray-100 p-3">
                        <p class="text-xl">🔔</p>
                        <p class="text-xs font-bold text-gray-700 mt-1">Notifications</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-guest-layout>