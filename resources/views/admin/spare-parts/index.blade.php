<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Spare Part Management
            </h2>

            <a href="{{ route('admin.spare-parts.create') }}"
               class="px-4 py-2 bg-blue-600 text-white rounded-md text-sm hover:bg-blue-700">
                Add Spare Part
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('error'))
    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-md">
        {{ session('error') }}
    </div>
@endif

            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <div class="p-6">
                    <h3 class="text-lg font-bold mb-4">
                        Spare Part Stock List
                    </h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full border border-gray-200 text-sm">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="border px-4 py-2 text-left">No.</th>
                                    <th class="border px-4 py-2 text-left">Part Name</th>
                                    <th class="border px-4 py-2 text-left">Category</th>
                                    <th class="border px-4 py-2 text-left">Unit Price</th>
                                    <th class="border px-4 py-2 text-left">Stock Quantity</th>
                                    <th class="border px-4 py-2 text-left">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($spareParts as $sparePart)
                                    <tr>
                                        <td class="border px-4 py-2">
                                            {{ $loop->iteration }}
                                        </td>
                                        <td class="border px-4 py-2">
                                            {{ $sparePart->part_name }}
                                        </td>
                                        <td class="border px-4 py-2">
                                            {{ $sparePart->category }}
                                        </td>
                                        <td class="border px-4 py-2">
                                            RM {{ number_format($sparePart->unit_price, 2) }}
                                        </td>
                                        <td class="border px-4 py-2">
                                            {{ $sparePart->stock_quantity }}
                                        </td>
                                        <td class="border px-4 py-2">
    <div class="flex items-center gap-2">
        <a href="{{ route('admin.spare-parts.show', $sparePart) }}"
           class="text-blue-600 hover:underline">
            View
        </a>

        <a href="{{ route('admin.spare-parts.edit', $sparePart) }}"
           class="text-yellow-600 hover:underline">
            Edit
        </a>

        <form method="POST"
              action="{{ route('admin.spare-parts.destroy', $sparePart) }}"
              onsubmit="return confirm('Are you sure you want to delete this spare part?');">
            @csrf
            @method('DELETE')

            <button type="submit" class="text-red-600 hover:underline">
                Delete
            </button>
        </form>
    </div>
</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="border px-4 py-4 text-center text-gray-500">
                                            No spare parts found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $spareParts->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>