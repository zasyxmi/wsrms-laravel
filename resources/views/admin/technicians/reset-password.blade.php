<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Reset Technician Password
            </h2>

            <a href="{{ route('admin.technicians.show', $technician) }}"
                class="ws-btn-secondary !w-auto">
                Back to Details
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="ws-card">
                <div class="p-6 space-y-6">
                    <div class="border-b pb-4">
                        <p class="text-sm text-gray-500">Technician</p>
                        <h3 class="text-2xl font-bold text-gray-900">
                            {{ $technician->user->name }}
                        </h3>
                        <p class="mt-1 text-sm text-gray-600">
                            {{ $technician->user->email }}
                        </p>
                    </div>

                    <form method="POST"
                        action="{{ route('admin.technicians.update-password', $technician) }}"
                        class="space-y-5">
                        @csrf
                        @method('PATCH')

                        <div>
                            <label for="password" class="ws-label">
                                New Password
                            </label>

                            <input type="password"
                                id="password"
                                name="password"
                                class="ws-input"
                                required
                                autocomplete="new-password">

                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="ws-label">
                                Confirm New Password
                            </label>

                            <input type="password"
                                id="password_confirmation"
                                name="password_confirmation"
                                class="ws-input"
                                required
                                autocomplete="new-password">
                        </div>

                        <div class="flex justify-end gap-3">
                            <a href="{{ route('admin.technicians.show', $technician) }}"
                                class="ws-btn-secondary !w-auto">
                                Cancel
                            </a>

                            <button type="submit" class="ws-btn-primary !w-auto">
                                Reset Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
