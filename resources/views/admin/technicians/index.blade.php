<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Technician Management
            </h2>

            <div class="flex gap-3">
                <a href="{{ route('admin.technicians.create') }}"
                    class="px-4 py-2 bg-blue-600 text-white rounded-md text-sm hover:bg-blue-700">
                    Add New Technician
                </a>

                <a href="{{ route('dashboard') }}"
                    class="px-4 py-2 bg-gray-600 text-white rounded-md text-sm hover:bg-gray-700">
                    Back to Dashboard
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

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

            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <div class="p-6">
                    <h3 class="text-lg font-bold mb-4">
                        All Technicians
                    </h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full border border-gray-200 text-sm">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="border px-4 py-2 text-left">Name</th>
                                    <th class="border px-4 py-2 text-left">Email</th>
                                    <th class="border px-4 py-2 text-left">Phone Number</th>
                                    <th class="border px-4 py-2 text-left">Specialization</th>
                                    <th class="border px-4 py-2 text-left">Availability</th>
                                    <th class="border px-4 py-2 text-left">Assigned Tasks</th>
                                    <th class="border px-4 py-2 text-left">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($technicians as $technician)
                                    <tr>
                                        <td class="border px-4 py-2 font-semibold">
                                            {{ $technician->user->name }}
                                        </td>

                                        <td class="border px-4 py-2">
                                            {{ $technician->user->email }}
                                        </td>

                                        <td class="border px-4 py-2">
                                            {{ $technician->user->phone_number ?? '-' }}
                                        </td>

                                        <td class="border px-4 py-2">
                                            {{ $technician->specialization }}
                                        </td>

                                        <td class="border px-4 py-2">
                                            @if ($technician->availability_status === 'available')
                                                <span class="px-2 py-1 rounded text-xs bg-green-100 text-green-700">
                                                    Available
                                                </span>
                                            @else
                                                <span class="px-2 py-1 rounded text-xs bg-yellow-100 text-yellow-700">
                                                    {{ ucwords(str_replace('_', ' ', $technician->availability_status)) }}
                                                </span>
                                            @endif
                                        </td>

                                        <td class="border px-4 py-2">
                                            {{ $technician->repair_requests_count }}
                                        </td>

                                        <td class="border px-4 py-2">
                                            <div class="flex gap-3 items-center">
                                                <a href="{{ route('admin.technicians.show', $technician) }}"
                                                    class="text-blue-600 hover:underline">
                                                    View
                                                </a>

                                                <a href="{{ route('admin.technicians.edit', $technician) }}"
                                                    class="text-green-600 hover:underline">
                                                    Edit
                                                </a>

                                                @if ($technician->repair_requests_count === 0)
                                                    <form method="POST"
                                                        action="{{ route('admin.technicians.destroy', $technician) }}"
                                                        onsubmit="return confirm('Are you sure you want to delete this technician?');">
                                                        @csrf
                                                        @method('DELETE')

                                                        <button type="submit" class="text-red-600 hover:underline">
                                                            Delete
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="text-gray-400 text-xs">
                                                        Cannot delete
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="border px-4 py-4 text-center text-gray-500">
                                            No technicians found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $technicians->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>