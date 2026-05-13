<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Generate Invoice
            </h2>

            <a href="{{ route('admin.repair-requests.show', $repairRequest) }}"
               class="px-4 py-2 bg-gray-600 text-white rounded-md text-sm hover:bg-gray-700">
                Back
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 space-y-6">

                    <div class="border-b pb-4">
                        <p class="text-sm text-gray-500">Repair Code</p>
                        <h3 class="text-2xl font-bold text-gray-900">
                            {{ $repairRequest->repair_code }}
                        </h3>

                        <p class="text-gray-600 mt-1">
                            Customer: {{ $repairRequest->customer->user->name }}
                        </p>

                        <p class="text-gray-600">
                            Device:
                            {{ $repairRequest->device->brand }}
                            {{ $repairRequest->device->model }}
                        </p>
                    </div>

                    <div>
                        <h3 class="text-lg font-bold text-gray-900 mb-3">
                            Spare Parts Used
                        </h3>

                        <div class="overflow-x-auto">
                            <table class="min-w-full border border-gray-200 text-sm">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="border px-4 py-2 text-left">Part Name</th>
                                        <th class="border px-4 py-2 text-left">Unit Price</th>
                                        <th class="border px-4 py-2 text-left">Quantity</th>
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
                                            <td colspan="4" class="border px-4 py-4 text-center text-gray-500">
                                                No spare parts recorded for this repair.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>

                                <tfoot>
                                    <tr class="bg-gray-50">
                                        <td colspan="3" class="border px-4 py-2 text-right font-bold">
                                            Spare Part Total
                                        </td>
                                        <td class="border px-4 py-2 font-bold">
                                            RM {{ number_format($sparePartTotal, 2) }}
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <form method="POST"
                          action="{{ route('admin.invoices.store', $repairRequest) }}"
                          class="space-y-5 border-t pt-6">
                        @csrf

                        <div>
                            <label for="diagnosis_fee" class="block text-sm font-medium text-gray-700">
                                Diagnosis Fee (RM)
                            </label>

                            <input type="number"
                                   step="0.01"
                                   min="0"
                                   id="diagnosis_fee"
                                   name="diagnosis_fee"
                                   value="{{ old('diagnosis_fee', 30) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">

                            @error('diagnosis_fee')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="service_charge" class="block text-sm font-medium text-gray-700">
                                Service Charge (RM)
                            </label>

                            <input type="number"
                                   step="0.01"
                                   min="0"
                                   id="service_charge"
                                   name="service_charge"
                                   value="{{ old('service_charge', 80) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">

                            @error('service_charge')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="additional_charge" class="block text-sm font-medium text-gray-700">
                                Additional Charge (RM)
                            </label>

                            <input type="number"
                                   step="0.01"
                                   min="0"
                                   id="additional_charge"
                                   name="additional_charge"
                                   value="{{ old('additional_charge', 0) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">

                            @error('additional_charge')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="bg-blue-50 p-4 rounded-md">
                            <p class="text-sm text-gray-600">
                                The system will automatically calculate:
                            </p>

                            <p class="font-semibold text-gray-900 mt-1">
                                Diagnosis Fee + Service Charge + Spare Part Total + Additional Charge
                            </p>
                        </div>

                        <div class="flex justify-end gap-3">
                            <a href="{{ route('admin.repair-requests.show', $repairRequest) }}"
                               class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md text-sm hover:bg-gray-300">
                                Cancel
                            </a>

                            <button type="submit"
                                    class="px-4 py-2 bg-blue-600 text-white rounded-md text-sm hover:bg-blue-700"
                                    onclick="return confirm('Generate invoice for this repair request?');">
                                Generate Invoice
                            </button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>