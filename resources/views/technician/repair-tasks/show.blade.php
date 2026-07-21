<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Repair Task Details
            </h2>

            <a href="{{ route('technician.repair-tasks.index') }}"
               class="px-4 py-2 bg-gray-600 text-white rounded-md text-sm hover:bg-gray-700">
                Back
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 space-y-6">

                    <div class="flex items-center justify-between border-b pb-4">
                        <div>
                            <p class="text-sm text-gray-500">Repair Code</p>
                            <h3 class="text-2xl font-bold text-gray-900">
                                {{ $repairRequest->repair_code }}
                            </h3>
                        </div>

                        @php
                            $statusLabel = in_array($repairRequest->status, ['approved', 'assigned'], true)
                                ? 'Approved - Waiting for Device'
                                : ucwords(str_replace('_', ' ', $repairRequest->status));
                        @endphp

                        <span class="px-3 py-1 rounded-full text-sm bg-blue-100 text-blue-700">
                            {{ $statusLabel }}
                        </span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-sm text-gray-500">Customer Name</p>
                            <p class="font-medium">
                                {{ $repairRequest->customer->user->name }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">Customer Email</p>
                            <p class="font-medium">
                                {{ $repairRequest->customer->user->email }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">Device Type</p>
                            <p class="font-medium">
                                {{ $repairRequest->device->device_type }}
                            </p>
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

                    @if (session('success'))
    <div class="p-4 bg-green-100 text-green-700 rounded-md">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="p-4 bg-red-100 text-red-700 rounded-md">
        {{ session('error') }}
    </div>
@endif

@if (! in_array($repairRequest->status, ['repair_completed', 'waiting_payment', 'paid', 'ready_for_pickup', 'completed', 'unable_to_repair'], true))
    <div class="border-t pt-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4">
            Update Diagnosis
        </h3>

        <form method="POST"
              action="{{ route('technician.repair-tasks.update-diagnosis', $repairRequest) }}"
              class="space-y-5">
            @csrf
            @method('PATCH')

            <div>
                <label for="diagnosis_result" class="block text-sm font-medium text-gray-700">
                    Diagnosis Result
                </label>

                <select id="diagnosis_result"
                        name="diagnosis_result"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">-- Select Diagnosis Result --</option>

                    @php
                        $diagnosisOptions = [
                            'Screen issue',
                            'Battery issue',
                            'Keyboard issue',
                            'Charging port issue',
                            'Motherboard issue',
                            'Software issue',
                            'Hardware issue',
                            'Other issue',
                        ];
                    @endphp

                    @foreach ($diagnosisOptions as $option)
                        <option value="{{ $option }}"
                            {{ old('diagnosis_result', $repairRequest->diagnosis_result) === $option ? 'selected' : '' }}>
                            {{ $option }}
                        </option>
                    @endforeach
                </select>

                @error('diagnosis_result')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="repair_notes" class="block text-sm font-medium text-gray-700">
                    Repair Notes
                </label>

                <textarea id="repair_notes"
                          name="repair_notes"
                          rows="5"
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                          placeholder="Example: Device screen is damaged and requires replacement.">{{ old('repair_notes', $repairRequest->repair_notes) }}</textarea>

                @error('repair_notes')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">
                    Repair Status
                </label>

                <select id="status"
                        name="status"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">-- Select Status --</option>

                    <option value="under_diagnosis" {{ old('status', $repairRequest->status) === 'under_diagnosis' ? 'selected' : '' }}>
                        Under Diagnosis
                    </option>

                    <option value="in_repair" {{ old('status', $repairRequest->status) === 'in_repair' ? 'selected' : '' }}>
                        In Repair
                    </option>

                    <option value="waiting_for_parts" {{ old('status', $repairRequest->status) === 'waiting_for_parts' ? 'selected' : '' }}>
                        Waiting for Parts
                    </option>

                    <option value="unable_to_repair" {{ old('status', $repairRequest->status) === 'unable_to_repair' ? 'selected' : '' }}>
                        Unable to Repair
                    </option>
                </select>

                @error('status')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end">
                <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-md text-sm hover:bg-blue-700">
                    Save Diagnosis Update
                </button>
            </div>
        </form>
    </div>
@else
    <div class="border-t pt-6">
        <p class="text-gray-700">
            This repair task has been closed and can no longer be updated.
        </p>
    </div>
@endif

<div class="border-t pt-6">
    <h3 class="text-lg font-bold text-gray-900 mb-4">
        Spare Parts Used
    </h3>

    <div class="overflow-x-auto mb-6">
        <table class="min-w-full border border-gray-200 text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-4 py-2 text-left">Part Name</th>
                    <th class="border px-4 py-2 text-left">Category</th>
                    <th class="border px-4 py-2 text-left">Unit Price</th>
                    <th class="border px-4 py-2 text-left">Quantity Used</th>
                    <th class="border px-4 py-2 text-left">Subtotal</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($repairRequest->repairSpareParts as $repairSparePart)
                    <tr>
                        <td class="border px-4 py-2">
                            {{ $repairSparePart->sparePart->part_name }}
                        </td>

                        <td class="border px-4 py-2">
                            {{ $repairSparePart->sparePart->category }}
                        </td>

                        <td class="border px-4 py-2">
                            RM {{ number_format($repairSparePart->unit_price, 2) }}
                        </td>

                        <td class="border px-4 py-2">
                            {{ $repairSparePart->quantity_used }}
                        </td>

                        <td class="border px-4 py-2 font-semibold">
                            RM {{ number_format($repairSparePart->subtotal, 2) }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="border px-4 py-4 text-center text-gray-500">
                            No spare parts have been recorded for this repair task.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if (! in_array($repairRequest->status, ['repair_completed', 'waiting_payment', 'paid', 'ready_for_pickup', 'completed', 'unable_to_repair'], true))
        <form method="POST"
              action="{{ route('technician.repair-tasks.store-spare-part', $repairRequest) }}"
              class="space-y-5">
            @csrf

            <div>
                <label for="spare_part_id" class="block text-sm font-medium text-gray-700">
                    Select Spare Part
                </label>

                <select id="spare_part_id"
                        name="spare_part_id"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">-- Select Spare Part --</option>

                    @foreach ($spareParts as $sparePart)
                        <option value="{{ $sparePart->id }}" {{ old('spare_part_id') == $sparePart->id ? 'selected' : '' }}>
                            {{ $sparePart->part_name }}
                            — RM {{ number_format($sparePart->unit_price, 2) }}
                            — Stock: {{ $sparePart->stock_quantity }}
                        </option>
                    @endforeach
                </select>

                @error('spare_part_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="quantity_used" class="block text-sm font-medium text-gray-700">
                    Quantity Used
                </label>

                <input type="number"
                       id="quantity_used"
                       name="quantity_used"
                       min="1"
                       value="{{ old('quantity_used', 1) }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">

                @error('quantity_used')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end">
                <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-md text-sm hover:bg-blue-700">
                    Add Spare Part Used
                </button>
            </div>
        </form>
    @else
        <p class="text-gray-700">
            Spare parts cannot be added because this repair task has been closed.
        </p>
    @endif
</div>

@if (! in_array($repairRequest->status, ['repair_completed', 'waiting_payment', 'paid', 'ready_for_pickup', 'completed', 'unable_to_repair', 'rejected'], true))
    <div class="border-t pt-6">
        <h3 class="text-lg font-bold text-gray-900 mb-3">
            Complete Repair Task
        </h3>

        <p class="text-gray-700 mb-4">
            Click the button below only after the device has been repaired and tested.
        </p>

        <form method="POST"
              action="{{ route('technician.repair-tasks.complete', $repairRequest) }}"
              onsubmit="return confirm('Are you sure this repair task is completed?');">
            @csrf
            @method('PATCH')

            <button type="submit"
                    class="px-4 py-2 bg-green-600 text-white rounded-md text-sm hover:bg-green-700">
                Mark Repair as Completed
            </button>
        </form>
    </div>
@endif

@if (in_array($repairRequest->status, ['repair_completed', 'waiting_payment', 'paid', 'ready_for_pickup', 'completed'], true))
    <div class="border-t pt-6">
        @if ($repairRequest->status === 'completed')
            <p class="text-green-700 font-semibold">
                This repair task has been completed.
            </p>

            <p class="text-gray-700 mt-1">
                Completed Date:
                {{ $repairRequest->completed_date ? $repairRequest->completed_date->format('d M Y') : '-' }}
            </p>
        @else
            <p class="text-blue-700 font-semibold">
                You have finished this repair. It's now waiting on admin (invoice, payment, and pickup) before it is fully closed.
            </p>
        @endif
    </div>
@endif

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
