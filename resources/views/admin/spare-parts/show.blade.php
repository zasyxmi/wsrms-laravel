<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Spare Part Details
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
                <div class="p-6 space-y-5">

                    <div>
                        <p class="text-sm text-gray-500">Part Name</p>
                        <p class="text-lg font-semibold text-gray-900">
                            {{ $sparePart->part_name }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Category</p>
                        <p class="text-gray-900">
                            {{ $sparePart->category }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Unit Price</p>
                        <p class="text-gray-900">
                            RM {{ number_format($sparePart->unit_price, 2) }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Stock Quantity</p>
                        <p class="text-gray-900">
                            {{ $sparePart->stock_quantity }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Created At</p>
                        <p class="text-gray-900">
                            {{ $sparePart->created_at->format('d M Y, h:i A') }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Last Updated</p>
                        <p class="text-gray-900">
                            {{ $sparePart->updated_at->format('d M Y, h:i A') }}
                        </p>
                    </div>

                    <div class="flex justify-end gap-3 pt-4">
                        <a href="{{ route('admin.spare-parts.edit', $sparePart) }}"
                           class="px-4 py-2 bg-yellow-500 text-white rounded-md text-sm hover:bg-yellow-600">
                            Edit Spare Part
                        </a>

                        <form method="POST"
                              action="{{ route('admin.spare-parts.destroy', $sparePart) }}"
                              onsubmit="return confirm('Are you sure you want to delete this spare part?');">
                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="px-4 py-2 bg-red-600 text-white rounded-md text-sm hover:bg-red-700">
                                Delete Spare Part
                            </button>
                        </form>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>