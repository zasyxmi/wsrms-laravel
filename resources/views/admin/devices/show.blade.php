<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Device Details
            </h2>

            <a href="{{ route('admin.devices.index') }}"
               class="px-4 py-2 bg-gray-600 text-white rounded-md text-sm hover:bg-gray-700">
                Back to Devices
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 space-y-6">

                    <div class="border-b pb-4">
                        <p class="text-sm text-gray-500">Device</p>
                        <h3 class="text-2xl font-bold text-gray-900">
                            {{ $device->brand }} {{ $device->model }}
                        </h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-sm text-gray-500">Customer Name</p>
                            <p class="font-medium">
                                {{ $device->customer->user->name }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">Customer Email</p>
                            <p class="font-medium">
                                {{ $device->customer->user->email }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">Device Type</p>
                            <p class="font-medium">
                                {{ $device->device_type }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">Serial Number</p>
                            <p class="font-medium">
                                {{ $device->serial_number ?? '-' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">Registered At</p>
                            <p class="font-medium">
                                {{ $device->created_at->format('d M Y, h:i A') }}
                            </p>
                        </div>
                    </div>

                </div>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">
                        Repair History for This Device
                    </h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full border border-gray-200 text-sm">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="border px-4 py-2 text-left">Repair Code</th>
                                    <th class="border px-4 py-2 text-left">Problem</th>
                                    <th class="border px-4 py-2 text-left">Technician</th>
                                    <th class="border px-4 py-2 text-left">Status</th>
                                    <th class="border px-4 py-2 text-left">Invoice</th>
                                    <th class="border px-4 py-2 text-left">Request Date</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($device->repairRequests as $repairRequest)
                                    <tr>
                                        <td class="border px-4 py-2 font-semibold">
                                            {{ $repairRequest->repair_code }}
                                        </td>

                                        <td class="border px-4 py-2">
                                            {{ \Illuminate\Support\Str::limit($repairRequest->issue_description, 60) }}
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

                                        <td class="border px-4 py-2">
                                            {{ $repairRequest->request_date ? $repairRequest->request_date->format('d M Y') : '-' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="border px-4 py-4 text-center text-gray-500">
                                            No repair history found for this device.
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