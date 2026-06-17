<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Submit Repair Request
            </h2>

            <a href="{{ route('dashboard') }}"
               class="px-4 py-2 bg-gray-600 text-white rounded-md text-sm hover:bg-gray-700">
                Back
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">

                    <form method="POST" action="{{ route('customer.repair-requests.store') }}" class="space-y-5">
                        @csrf

                        <div>
                            <label for="device_type" class="block text-sm font-medium text-gray-700">
                                Device Type
                            </label>
                            <select id="device_type"
                                    name="device_type"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">-- Select Device Type --</option>
                                <option value="Handphone" {{ old('device_type') === 'Handphone' ? 'selected' : '' }}>Handphone</option>
                                <option value="Laptop" {{ old('device_type') === 'Laptop' ? 'selected' : '' }}>Laptop</option>
                                <option value="PC" {{ old('device_type') === 'PC' ? 'selected' : '' }}>PC</option>
                            </select>

                            @error('device_type')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="brand" class="block text-sm font-medium text-gray-700">
                                Brand
                            </label>
                            <input type="text"
                                   id="brand"
                                   name="brand"
                                   value="{{ old('brand') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                   placeholder="Example: Apple, Samsung, Dell">

                            @error('brand')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="model" class="block text-sm font-medium text-gray-700">
                                Model
                            </label>
                            <input type="text"
                                   id="model"
                                   name="model"
                                   value="{{ old('model') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                   placeholder="Example: iPhone 12, Dell Inspiron 15">

                            @error('model')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="serial_number" class="block text-sm font-medium text-gray-700">
                                Serial Number
                            </label>
                            <input type="text"
                                   id="serial_number"
                                   name="serial_number"
                                   value="{{ old('serial_number') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                   placeholder="Optional">

                            @error('serial_number')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="issue_description" class="block text-sm font-medium text-gray-700">
                                Problem Description
                            </label>
                            <textarea id="issue_description"
                                      name="issue_description"
                                      rows="5"
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                      placeholder="Describe the problem clearly...">{{ old('issue_description') }}</textarea>

                            @error('issue_description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="preferred_contact_method" class="block text-sm font-medium text-gray-700">
                                Preferred Contact Method
                            </label>
                            <select id="preferred_contact_method"
                                    name="preferred_contact_method"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">-- Select Contact Method --</option>
                                <option value="WhatsApp" {{ old('preferred_contact_method') === 'WhatsApp' ? 'selected' : '' }}>WhatsApp</option>
                                <option value="Email" {{ old('preferred_contact_method') === 'Email' ? 'selected' : '' }}>Email</option>
                                <option value="Phone Call" {{ old('preferred_contact_method') === 'Phone Call' ? 'selected' : '' }}>Phone Call</option>
                            </select>

                            @error('preferred_contact_method')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end gap-3">
                            <a href="{{ route('dashboard') }}"
                               class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md text-sm hover:bg-gray-300">
                                Cancel
                            </a>

                            <button type="submit"
                                    class="px-4 py-2 bg-blue-600 text-white rounded-md text-sm hover:bg-blue-700">
                                Submit Request
                            </button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
