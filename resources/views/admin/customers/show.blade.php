<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Customer Details
            </h2>

            <a href="{{ route('admin.customers.index') }}"
               class="px-4 py-2 bg-gray-600 text-white rounded-md text-sm hover:bg-gray-700">
                Back to Customers
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 space-y-6">

                    <div class="border-b pb-4">
                        <p class="text-sm text-gray-500">Customer Name</p>
                        <h3 class="text-2xl font-bold text-gray-900">
                            {{ $customer->user->name }}
                        </h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-sm text-gray-500">Email</p>
                            <p class="font-medium">
                                {{ $customer->user->email }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">Phone Number</p>
                            <p class="font-medium">
                                {{ $customer->user->phone_number ?? '-' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">Address</p>
                            <p class="font-medium">
                                {{ $customer->address ?? '-' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">Registered At</p>
                            <p class="font-medium">
                                {{ $customer->created_at->format('d M Y, h:i A') }}
                            </p>
                        </div>
                    </div>

                </div>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">
                        Device Records
                    </h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full border border-gray-200 text-sm">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="border px-4 py-2 text-left">Device Type</th>
                                    <th class="border px-4 py-2 text-left">Brand</th>
                                    <th class="border px-4 py-2 text-left">Model</th>
                                    <th class="border px-4 py-2 text-left">Serial Number</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($customer->devices as $device)
                                    <tr>
                                        <td class="border px-4 py-2">{{ $device->device_type }}</td>
                                        <td class="border px-4 py-2">{{ $device->brand }}</td>
                                        <td class="border px-4 py-2">{{ $device->model }}</td>
                                        <td class="border px-4 py-2">{{ $device->serial_number ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="border px-4 py-4 text-center text-gray-500">
                                            No devices found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">
                        Repair Request History
                    </h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full border border-gray-200 text-sm">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="border px-4 py-2 text-left">Repair Code</th>
                                    <th class="border px-4 py-2 text-left">Device</th>
                                    <th class="border px-4 py-2 text-left">Problem</th>
                                    <th class="border px-4 py-2 text-left">Technician</th>
                                    <th class="border px-4 py-2 text-left">Status</th>
                                    <th class="border px-4 py-2 text-left">Invoice</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($customer->repairRequests as $repairRequest)
                                    <tr>
                                        <td class="border px-4 py-2 font-semibold">
                                            {{ $repairRequest->repair_code }}
                                        </td>

                                        <td class="border px-4 py-2">
                                            {{ $repairRequest->device->brand }}
                                            {{ $repairRequest->device->model }}
                                        </td>

                                        <td class="border px-4 py-2">
                                            {{ \Illuminate\Support\Str::limit($repairRequest->issue_description, 50) }}
                                        </td>

                                        <td class="border px-4 py-2">
                                            {{ $repairRequest->technician?->user?->name ?? '-' }}
                                        </td>

                                        <td class="border px-4 py-2">
                                            {{ ucwords(str_replace('_', ' ', $repairRequest->status)) }}
                                        </td>

                                        <td class="border px-4 py-2">
                                            @if ($repairRequest->invoice)
                                                {{ $repairRequest->invoice->invoice_number }}
                                                —
                                                {{ ucwords($repairRequest->invoice->status) }}
                                            @else
                                                No invoice
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="border px-4 py-4 text-center text-gray-500">
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
    </div>
</x-app-layout>