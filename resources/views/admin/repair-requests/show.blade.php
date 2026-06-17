<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Repair Request Details
            </h2>

            <a href="{{ route('admin.repair-requests.index') }}"
                class="px-4 py-2 bg-gray-600 text-white rounded-md text-sm hover:bg-gray-700">
                Back
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
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

            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 space-y-6">

                    <div class="flex items-center justify-between border-b pb-4">
                        <div>
                            <p class="text-sm text-gray-500">Repair Code</p>
                            <h3 class="text-2xl font-bold text-gray-900">
                                {{ $repairRequest->repair_code }}
                            </h3>
                        </div>

                        <span class="px-3 py-1 rounded-full text-sm bg-blue-100 text-blue-700">
                            {{ ucwords(str_replace('_', ' ', $repairRequest->status)) }}
                        </span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-sm text-gray-500">Customer Name</p>
                            <p class="font-medium">{{ $repairRequest->customer->user->name }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">Customer Email</p>
                            <p class="font-medium">{{ $repairRequest->customer->user->email }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">Device Type</p>
                            <p class="font-medium">{{ $repairRequest->device->device_type }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">Brand & Model</p>
                            <p class="font-medium">
                                {{ $repairRequest->device->brand }}
                                {{ $repairRequest->device->model }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">Serial Number</p>
                            <p class="font-medium">
                                {{ $repairRequest->device->serial_number ?? '-' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">Preferred Contact Method</p>
                            <p class="font-medium">
                                {{ $repairRequest->preferred_contact_method }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">Assigned Technician</p>
                            <p class="font-medium">
                                {{ $repairRequest->technician?->user?->name ?? 'Not assigned yet' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">Assignment Status</p>
                            <p class="font-medium">
                                {{ $repairRequest->technician ? 'Assigned' : 'Waiting for assignment' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">Request Date</p>
                            <p class="font-medium">
                                {{ $repairRequest->request_date->format('d M Y') }}
                            </p>
                        </div>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Problem Description</p>
                        <p class="mt-1 text-gray-800">
                            {{ $repairRequest->issue_description }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Diagnosis Result</p>
                        <p class="mt-1 text-gray-800">
                            {{ $repairRequest->diagnosis_result ?? 'No diagnosis has been recorded yet.' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Repair Notes</p>
                        <p class="mt-1 text-gray-800">
                            {{ $repairRequest->repair_notes ?? 'No repair notes available yet.' }}
                        </p>
                    </div>

                    @if ($repairRequest->status === 'submitted')
                        <div class="border-t pt-6">
                            <p class="text-sm text-gray-500 mb-3">Admin Action</p>

                            <div class="flex gap-3">
                                <form method="POST" action="{{ route('admin.repair-requests.approve', $repairRequest) }}">
                                    @csrf
                                    @method('PATCH')

                                    <button type="submit"
                                        class="px-4 py-2 bg-green-600 text-white rounded-md text-sm hover:bg-green-700"
                                        onclick="return confirm('Approve this repair request?')">
                                        Approve Request
                                    </button>
                                </form>

                                <form method="POST" action="{{ route('admin.repair-requests.reject', $repairRequest) }}">
                                    @csrf
                                    @method('PATCH')

                                    <button type="submit"
                                        class="px-4 py-2 bg-red-600 text-white rounded-md text-sm hover:bg-red-700"
                                        onclick="return confirm('Reject this repair request?')">
                                        Reject Request
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif

                    @if (in_array($repairRequest->status, ['approved', 'assigned'], true))
                        <div class="border-t pt-6">
                            <p class="text-sm text-gray-500 mb-3">Technician Assignment</p>

                            <a href="{{ route('admin.repair-requests.assign-form', $repairRequest) }}"
                                class="inline-block px-4 py-2 bg-blue-600 text-white rounded-md text-sm hover:bg-blue-700">
                                {{ $repairRequest->technician ? 'Reassign Technician' : 'Assign Technician' }}
                            </a>
                        </div>
                    @endif

                    @if ($repairRequest->status === 'completed' && !$repairRequest->invoice)
                        <div class="border-t pt-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-3">
                                Invoice
                            </h3>

                            <p class="text-gray-700 mb-4">
                                This repair has been completed. You can now generate the invoice for the customer.
                            </p>

                            <a href="{{ route('admin.invoices.create', $repairRequest) }}"
                                class="inline-block px-4 py-2 bg-blue-600 text-white rounded-md text-sm hover:bg-blue-700">
                                Generate Invoice
                            </a>
                        </div>
                    @endif

                    @if ($repairRequest->invoice)
                        <div class="border-t pt-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-3">
                                Invoice
                            </h3>

                            <div class="bg-green-50 p-4 rounded-md">
                                <p class="font-semibold text-green-800">
                                    Invoice has been generated.
                                </p>

                                <p class="text-gray-700 mt-1">
                                    Invoice Number: {{ $repairRequest->invoice->invoice_number }}
                                </p>

                                <p class="text-gray-700">
                                    Total Amount: RM {{ number_format($repairRequest->invoice->total_amount, 2) }}
                                </p>

                                <p class="text-gray-700">
                                    Status: {{ ucwords($repairRequest->invoice->status) }}
                                </p>
                            </div>
                        </div>
                    @endif

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
