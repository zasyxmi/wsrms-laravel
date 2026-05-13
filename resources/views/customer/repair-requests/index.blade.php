<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                My Repair Requests
            </h2>

            <a href="{{ route('customer.repair-requests.create') }}"
               class="px-4 py-2 bg-blue-600 text-white rounded-md text-sm hover:bg-blue-700">
                Submit New Request
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

            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <div class="p-6">
                    <h3 class="text-lg font-bold mb-4">Repair Request History</h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full border border-gray-200 text-sm">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="border px-4 py-2 text-left">Repair Code</th>
                                    <th class="border px-4 py-2 text-left">Device</th>
                                    <th class="border px-4 py-2 text-left">Problem</th>
                                    <th class="border px-4 py-2 text-left">Technician</th>
                                    <th class="border px-4 py-2 text-left">Status</th>
                                    <th class="border px-4 py-2 text-left">Request Date</th>
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
                                            {{ $repairRequest->device->brand }}
                                            {{ $repairRequest->device->model }}
                                        </td>

                                        <td class="border px-4 py-2">
                                            {{ Str::limit($repairRequest->issue_description, 50) }}
                                        </td>

                                        <td class="border px-4 py-2">
                                            {{ $repairRequest->technician?->user?->name ?? 'Not assigned yet' }}
                                        </td>

                                        <td class="border px-4 py-2">
                                            <span class="px-2 py-1 rounded text-xs bg-blue-100 text-blue-700">
                                                {{ ucwords(str_replace('_', ' ', $repairRequest->status)) }}
                                            </span>
                                        </td>

                                        <td class="border px-4 py-2">
                                            {{ $repairRequest->request_date->format('d M Y') }}
                                        </td>

                                        <td class="border px-4 py-2">
                                            <a href="{{ route('customer.repair-requests.show', $repairRequest) }}"
                                               class="text-blue-600 hover:underline">
                                                View Details
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="border px-4 py-4 text-center text-gray-500">
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