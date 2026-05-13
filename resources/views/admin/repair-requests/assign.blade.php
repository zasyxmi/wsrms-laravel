<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Assign Technician
            </h2>

            <a href="{{ route('admin.repair-requests.show', $repairRequest) }}"
               class="px-4 py-2 bg-gray-600 text-white rounded-md text-sm hover:bg-gray-700">
                Back
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 space-y-6">

                    <div class="border-b pb-4">
                        <p class="text-sm text-gray-500">Repair Code</p>
                        <h3 class="text-2xl font-bold text-gray-900">
                            {{ $repairRequest->repair_code }}
                        </h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-sm text-gray-500">Customer</p>
                            <p class="font-medium">{{ $repairRequest->customer->user->name }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">Device</p>
                            <p class="font-medium">
                                {{ $repairRequest->device->brand }}
                                {{ $repairRequest->device->model }}
                            </p>
                        </div>

                        <div class="md:col-span-2">
                            <p class="text-sm text-gray-500">Problem Description</p>
                            <p class="font-medium">{{ $repairRequest->issue_description }}</p>
                        </div>
                    </div>

                    <form method="POST"
                          action="{{ route('admin.repair-requests.assign', $repairRequest) }}"
                          class="space-y-5 border-t pt-6">
                        @csrf
                        @method('PATCH')

                        <div>
                            <label for="technician_id" class="block text-sm font-medium text-gray-700">
                                Select Technician
                            </label>

                            <select id="technician_id"
                                    name="technician_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">-- Select Technician --</option>

                                @foreach ($technicians as $technician)
                                    <option value="{{ $technician->id }}" {{ old('technician_id') == $technician->id ? 'selected' : '' }}>
                                        {{ $technician->user->name }}
                                        — {{ $technician->specialization }}
                                        — {{ ucfirst($technician->availability_status) }}
                                    </option>
                                @endforeach
                            </select>

                            @error('technician_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end gap-3">
                            <a href="{{ route('admin.repair-requests.show', $repairRequest) }}"
                               class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md text-sm hover:bg-gray-300">
                                Cancel
                            </a>

                            <button type="submit"
                                    class="px-4 py-2 bg-blue-600 text-white rounded-md text-sm hover:bg-blue-700">
                                Assign Technician
                            </button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>