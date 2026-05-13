<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Device Management
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
                        All Registered Devices
                    </h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full border border-gray-200 text-sm">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="border px-4 py-2 text-left">Customer</th>
                                    <th class="border px-4 py-2 text-left">Device Type</th>
                                    <th class="border px-4 py-2 text-left">Brand</th>
                                    <th class="border px-4 py-2 text-left">Model</th>
                                    <th class="border px-4 py-2 text-left">Serial Number</th>
                                    <th class="border px-4 py-2 text-left">Repair Requests</th>
                                    <th class="border px-4 py-2 text-left">Registered At</th>
                                    <th class="border px-4 py-2 text-left">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($devices as $device)
                                    <tr>
                                        <td class="border px-4 py-2 font-semibold">
                                            {{ $device->customer->user->name }}
                                        </td>

                                        <td class="border px-4 py-2">
                                            {{ $device->device_type }}
                                        </td>

                                        <td class="border px-4 py-2">
                                            {{ $device->brand }}
                                        </td>

                                        <td class="border px-4 py-2">
                                            {{ $device->model }}
                                        </td>

                                        <td class="border px-4 py-2">
                                            {{ $device->serial_number ?? '-' }}
                                        </td>

                                        <td class="border px-4 py-2">
                                            {{ $device->repair_requests_count }}
                                        </td>

                                        <td class="border px-4 py-2">
                                            {{ $device->created_at->format('d M Y, h:i A') }}
                                        </td>

                                        <td class="border px-4 py-2">
                                            <a href="{{ route('admin.devices.show', $device) }}"
                                               class="text-blue-600 hover:underline">
                                                View Details
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="border px-4 py-4 text-center text-gray-500">
                                            No devices found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $devices->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>