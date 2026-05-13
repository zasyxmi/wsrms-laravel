<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Spare Part
            </h2>

            <a href="{{ route('admin.spare-parts.index') }}"
               class="px-4 py-2 bg-gray-600 text-white rounded-md text-sm hover:bg-gray-700">
                Back
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">

                    <form method="POST" action="{{ route('admin.spare-parts.update', $sparePart) }}" class="space-y-5">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="part_name" class="block text-sm font-medium text-gray-700">
                                Part Name
                            </label>
                            <input type="text"
                                   id="part_name"
                                   name="part_name"
                                   value="{{ old('part_name', $sparePart->part_name) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">

                            @error('part_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700">
                                Category
                            </label>
                            <select id="category"
                                    name="category"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">-- Select Category --</option>
                                <option value="Phone" {{ old('category', $sparePart->category) === 'Phone' ? 'selected' : '' }}>
                                    Phone
                                </option>
                                <option value="Laptop" {{ old('category', $sparePart->category) === 'Laptop' ? 'selected' : '' }}>
                                    Laptop
                                </option>
                                <option value="Accessory" {{ old('category', $sparePart->category) === 'Accessory' ? 'selected' : '' }}>
                                    Accessory
                                </option>
                                <option value="Other" {{ old('category', $sparePart->category) === 'Other' ? 'selected' : '' }}>
                                    Other
                                </option>
                            </select>

                            @error('category')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="unit_price" class="block text-sm font-medium text-gray-700">
                                Unit Price (RM)
                            </label>
                            <input type="number"
                                   step="0.01"
                                   min="0"
                                   id="unit_price"
                                   name="unit_price"
                                   value="{{ old('unit_price', $sparePart->unit_price) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">

                            @error('unit_price')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="stock_quantity" class="block text-sm font-medium text-gray-700">
                                Stock Quantity
                            </label>
                            <input type="number"
                                   min="0"
                                   id="stock_quantity"
                                   name="stock_quantity"
                                   value="{{ old('stock_quantity', $sparePart->stock_quantity) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">

                            @error('stock_quantity')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end gap-3">
                            <a href="{{ route('admin.spare-parts.index') }}"
                               class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md text-sm hover:bg-gray-300">
                                Cancel
                            </a>

                            <button type="submit"
                                    class="px-4 py-2 bg-blue-600 text-white rounded-md text-sm hover:bg-blue-700">
                                Update Spare Part
                            </button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>