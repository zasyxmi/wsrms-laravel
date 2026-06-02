<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Technician Details
            </h2>

            <div class="flex gap-3">
                <a href="{{ route('admin.technicians.edit', $technician) }}"
                    class="px-4 py-2 bg-green-600 text-white rounded-md text-sm hover:bg-green-700">
                    Edit Technician
                </a>

                <a href="{{ route('admin.technicians.reset-password', $technician) }}"
                    class="ws-btn-secondary !w-auto !px-4 !py-2 !rounded-md !text-sm whitespace-nowrap">
                    Reset Password
                </a>

                @if ($technician->repairRequests->count() === 0)
                    <form method="POST" action="{{ route('admin.technicians.destroy', $technician) }}"
                        onsubmit="return confirm('Are you sure you want to delete this technician?');">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md text-sm hover:bg-red-700">
                            Delete Technician
                        </button>
                    </form>
                @endif

                <a href="{{ route('admin.technicians.index') }}"
                    class="px-4 py-2 bg-gray-600 text-white rounded-md text-sm hover:bg-gray-700">
                    Back to Technicians
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 space-y-6">

                    <div class="border-b pb-4">
                        <p class="text-sm text-gray-500">Technician Name</p>
                        <h3 class="text-2xl font-bold text-gray-900">
                            {{ $technician->user->name }}
                        </h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-sm text-gray-500">Email</p>
                            <p class="font-medium">
                                {{ $technician->user->email }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">Phone Number</p>
                            <p class="font-medium">
                                {{ $technician->user->phone_number ?? '-' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">Specialization</p>
                            <p class="font-medium">
                                {{ $technician->specialization }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">Availability Status</p>
                            <p class="font-medium">
                                {{ ucwords(str_replace('_', ' ', $technician->availability_status)) }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">Registered At</p>
                            <p class="font-medium">
                                {{ $technician->created_at->format('d M Y, h:i A') }}
                            </p>
                        </div>
                    </div>

                </div>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">
                        Assigned Repair Task History
                    </h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full border border-gray-200 text-sm">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="border px-4 py-2 text-left">Repair Code</th>
                                    <th class="border px-4 py-2 text-left">Customer</th>
                                    <th class="border px-4 py-2 text-left">Device</th>
                                    <th class="border px-4 py-2 text-left">Problem</th>
                                    <th class="border px-4 py-2 text-left">Status</th>
                                    <th class="border px-4 py-2 text-left">Invoice</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($technician->repairRequests as $repairRequest)
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
                                            {{ \Illuminate\Support\Str::limit($repairRequest->issue_description, 50) }}
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
                                            No assigned repair tasks found.
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
