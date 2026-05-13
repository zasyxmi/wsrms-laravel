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
                            Create your customer account for
                            <span class="text-amber-300">easy repair tracking.</span>
                        </h2>

                        <p class="mt-5 text-blue-50 text-lg leading-relaxed max-w-xl">
                            Register once, submit repair requests, track repair progress,
                            view invoices, make payment, download receipts, and receive pickup alerts.
                        </p>
                    </div>

                    <div class="mt-10 space-y-4">
                        <div class="bg-white/12 border border-white/15 rounded-2xl p-5 backdrop-blur">
                            <div class="flex gap-4">
                                <div class="w-12 h-12 rounded-xl bg-white/15 flex items-center justify-center text-2xl">
                                    📋
                                </div>

                                <div>
                                    <p class="font-bold">Real-Time Repair Tracking</p>
                                    <p class="text-sm text-blue-100 mt-1">
                                        Monitor your PC, laptop, or handphone repair status from request to pickup.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white/12 border border-white/15 rounded-2xl p-5 backdrop-blur">
                            <div class="flex gap-4">
                                <div class="w-12 h-12 rounded-xl bg-white/15 flex items-center justify-center text-2xl">
                                    💳
                                </div>

                                <div>
                                    <p class="font-bold">Invoices, Payments & Receipts</p>
                                    <p class="text-sm text-blue-100 mt-1">
                                        View invoice details, complete payment simulation, and download receipt PDF.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white/12 border border-white/15 rounded-2xl p-5 backdrop-blur">
                            <div class="flex gap-4">
                                <div class="w-12 h-12 rounded-xl bg-white/15 flex items-center justify-center text-2xl">
                                    🔔
                                </div>

                                <div>
                                    <p class="font-bold">Pickup Notification</p>
                                    <p class="text-sm text-blue-100 mt-1">
                                        Receive notification and email when your repaired device is ready for pickup.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-10 bg-white/10 border border-white/15 rounded-2xl p-5 backdrop-blur">
                        <div class="grid grid-cols-3 gap-4 text-center">
                            <div>
                                <p class="text-2xl font-extrabold">PC</p>
                                <p class="text-xs text-blue-100 mt-1">Repair</p>
                            </div>

                            <div>
                                <p class="text-2xl font-extrabold">Laptop</p>
                                <p class="text-xs text-blue-100 mt-1">Service</p>
                            </div>

                            <div>
                                <p class="text-2xl font-extrabold">Phone</p>
                                <p class="text-xs text-blue-100 mt-1">Fix</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="ws-card-soft p-8 lg:p-10 flex flex-col justify-center border-t-4 border-blue-600">
                <div class="mb-8">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 text-blue-700 text-sm font-bold mb-4">
                        <span>👤</span>
                        Customer Registration
                    </div>

                    <h2 class="ws-heading text-3xl">
                        Create Customer Account
                    </h2>

                    <p class="ws-subtext mt-2">
                        Fill in your details to start using the repair management system.
                    </p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label for="name" class="ws-label">
                            Full Name
                        </label>

                        <input id="name"
                               type="text"
                               name="name"
                               value="{{ old('name') }}"
                               required
                               autofocus
                               autocomplete="name"
                               placeholder="Enter your full name"
                               class="ws-input">

                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="ws-label">
                            Email Address
                        </label>

                        <input id="email"
                               type="email"
                               name="email"
                               value="{{ old('email') }}"
                               required
                               autocomplete="username"
                               placeholder="you@example.com"
                               class="ws-input">

                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="phone_number" class="ws-label">
                            Phone Number
                        </label>

                        <input id="phone_number"
                               type="text"
                               name="phone_number"
                               value="{{ old('phone_number') }}"
                               autocomplete="tel"
                               placeholder="Example: 0123456789"
                               class="ws-input">

                        @error('phone_number')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="password" class="ws-label">
                                Password
                            </label>

                            <input id="password"
                                   type="password"
                                   name="password"
                                   required
                                   autocomplete="new-password"
                                   placeholder="Create password"
                                   class="ws-input">

                            @error('password')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="ws-label">
                                Confirm Password
                            </label>

                            <input id="password_confirmation"
                                   type="password"
                                   name="password_confirmation"
                                   required
                                   autocomplete="new-password"
                                   placeholder="Confirm password"
                                   class="ws-input">

                            @error('password_confirmation')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <label class="flex items-start gap-3 rounded-2xl bg-slate-50 border border-slate-200 p-4">
                        <input type="checkbox"
                               required
                               class="mt-1 rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">

                        <span class="text-sm text-gray-600">
                            I confirm that the information provided is correct and I agree to use this system for workshop repair service management.
                        </span>
                    </label>

                    <button type="submit" class="ws-btn-primary w-full">
                        Register Account
                    </button>
                </form>

                <div class="my-8 flex items-center gap-4">
                    <div class="h-px bg-gray-200 flex-1"></div>
                    <p class="text-sm text-gray-500">Already registered?</p>
                    <div class="h-px bg-gray-200 flex-1"></div>
                </div>

                <a href="{{ route('login') }}"
                   class="ws-btn-secondary w-full">
                    Sign In to Existing Account
                </a>

                <div class="mt-8 grid grid-cols-1 sm:grid-cols-3 gap-3 text-center">
                    <div class="rounded-2xl bg-gray-50 border border-gray-100 p-3">
                        <p class="text-xl">🛡️</p>
                        <p class="text-xs font-bold text-gray-700 mt-1">Secure</p>
                    </div>

                    <div class="rounded-2xl bg-gray-50 border border-gray-100 p-3">
                        <p class="text-xl">⚙️</p>
                        <p class="text-xs font-bold text-gray-700 mt-1">Reliable</p>
                    </div>

                    <div class="rounded-2xl bg-gray-50 border border-gray-100 p-3">
                        <p class="text-xl">📩</p>
                        <p class="text-xs font-bold text-gray-700 mt-1">Email Alert</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-guest-layout>