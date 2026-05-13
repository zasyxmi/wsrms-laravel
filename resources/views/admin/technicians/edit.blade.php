<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Technician
            </h2>

            <a href="{{ route('admin.technicians.show', $technician) }}"
               class="px-4 py-2 bg-gray-600 text-white rounded-md text-sm hover:bg-gray-700">
                Back to Details
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">

                    <form method="POST"
                          action="{{ route('admin.technicians.update', $technician) }}"
                          class="space-y-5">
                        @csrf
                        @method('PATCH')

                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">
                                Technician Name
                            </label>

                            <input type="text"
                                   id="name"
                                   name="name"
                                   value="{{ old('name', $technician->user->name) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">

                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">
                                Email
                            </label>

                            <input type="email"
                                   value="{{ $technician->user->email }}"
                                   disabled
                                   class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm">

                            <p class="text-xs text-gray-500 mt-1">
                                Email cannot be edited in this form.
                            </p>
                        </div>

                        <div>
                            <label for="phone_number" class="block text-sm font-medium text-gray-700">
                                Phone Number
                            </label>

                            <input type="text"
                                   id="phone_number"
                                   name="phone_number"
                                   value="{{ old('phone_number', $technician->user->phone_number) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">

                            @error('phone_number')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="specialization" class="block text-sm font-medium text-gray-700">
                                Specialization
                            </label>

                            <input type="text"
                                   id="specialization"
                                   name="specialization"
                                   value="{{ old('specialization', $technician->specialization) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">

                            @error('specialization')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="availability_status" class="block text-sm font-medium text-gray-700">
                                Availability Status
                            </label>

                            <select id="availability_status"
                                    name="availability_status"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="available" {{ old('availability_status', $technician->availability_status) === 'available' ? 'selected' : '' }}>
                                    Available
                                </option>

                                <option value="busy" {{ old('availability_status', $technician->availability_status) === 'busy' ? 'selected' : '' }}>
                                    Busy
                                </option>

                                <option value="on_leave" {{ old('availability_status', $technician->availability_status) === 'on_leave' ? 'selected' : '' }}>
                                    On Leave
                                </option>
                            </select>

                            @error('availability_status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="bg-yellow-50 p-4 rounded-md">
                            <p class="text-sm text-gray-700">
                                Use this form to update technician profile information and availability.
                                Password changes are not included in this form.
                            </p>
                        </div>

                        <div class="flex justify-end gap-3">
                            <a href="{{ route('admin.technicians.show', $technician) }}"
                               class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md text-sm hover:bg-gray-300">
                                Cancel
                            </a>

                            <button type="submit"
                                    class="px-4 py-2 bg-blue-600 text-white rounded-md text-sm hover:bg-blue-700">
                                Update Technician
                            </button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>