<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Repair Request Management
            </h2>

            <a href="{{ route('dashboard') }}"
               class="px-4 py-2 bg-gray-600 text-white rounded-md text-sm hover:bg-gray-700">
                Back to Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-md">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <div class="p-6">
                    <h3 class="text-lg font-bold mb-4">All Repair Requests</h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full border border-gray-200 text-sm">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="border px-4 py-2 text-left">Repair Code</th>
                                    <th class="border px-4 py-2 text-left">Customer</th>
                                    <th class="border px-4 py-2 text-left">Device</th>
                                    <th class="border px-4 py-2 text-left">Device Type</th>
                                    <th class="border px-4 py-2 text-left">Problem</th>
                                    <th class="border px-4 py-2 text-left">Technician</th>
                                    <th class="border px-4 py-2 text-left">Assignment</th>
                                    <th class="border px-4 py-2 text-left">Status</th>
                                    <th class="border px-4 py-2 text-left">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($repairRequests as $repairRequest)
                                    <tr>
                                        <td class="border px-4 py-2 font-semibold">
                                            {{ $repairRequest->repair_code }}
                                        </td>

                                        <td class="border px-4 py-2">
                                            {{ $repairRequest->customer->user->name }}
                                        </td>

                                        <td class="border px-4 py-2">
                                            {{ $repairRequest->device->brand }}
                                            {{ $repairRequest->device->model }}
                                        </td>

                                        <td class="border px-4 py-2">
                                            {{ $repairRequest->device->device_type ?? '-' }}
                                        </td>

                                        <td class="border px-4 py-2">
                                            {{ \Illuminate\Support\Str::limit($repairRequest->issue_description, 50) }}
                                        </td>

                                        <td class="border px-4 py-2">
                                            {{ $repairRequest->technician?->user?->name ?? 'Not assigned yet' }}
                                        </td>

                                        <td class="border px-4 py-2">
                                            @if ($repairRequest->technician)
                                                Assigned
                                            @else
                                                Waiting for assignment
                                            @endif
                                        </td>

                                        <td class="border px-4 py-2">
                                            @php
                                                $statusLabel = in_array($repairRequest->status, ['approved', 'assigned'], true)
                                                    ? 'Approved - Waiting for Device'
                                                    : ucwords(str_replace('_', ' ', $repairRequest->status));
                                            @endphp

                                            <span class="px-2 py-1 rounded text-xs bg-blue-100 text-blue-700">
                                                {{ $statusLabel }}
                                            </span>
                                        </td>

                                        <td class="border px-4 py-2">
                                            <a href="{{ route('admin.repair-requests.show', $repairRequest) }}"
                                               class="text-blue-600 hover:underline">
                                                View Details
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="border px-4 py-4 text-center text-gray-500">
                                            No repair requests found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $repairRequests->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
