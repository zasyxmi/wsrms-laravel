<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Customer Management
            </h2>

            <a href="{{ route('dashboard') }}"
               class="px-4 py-2 bg-gray-600 text-white rounded-md text-sm hover:bg-gray-700">
                Back to Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <div class="p-6">
                    <h3 class="text-lg font-bold mb-4">
                        All Customers
                    </h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full border border-gray-200 text-sm">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="border px-4 py-2 text-left">Name</th>
                                    <th class="border px-4 py-2 text-left">Email</th>
                                    <th class="border px-4 py-2 text-left">Phone Number</th>
                                    <th class="border px-4 py-2 text-left">Address</th>
                                    <th class="border px-4 py-2 text-left">Registered At</th>
                                    <th class="border px-4 py-2 text-left">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($customers as $customer)
                                    <tr>
                                        <td class="border px-4 py-2 font-semibold">
                                            {{ $customer->user->name }}
                                        </td>

                                        <td class="border px-4 py-2">
                                            {{ $customer->user->email }}
                                        </td>

                                        <td class="border px-4 py-2">
                                            {{ $customer->user->phone_number ?? '-' }}
                                        </td>

                                        <td class="border px-4 py-2">
                                            {{ $customer->address ?? '-' }}
                                        </td>

                                        <td class="border px-4 py-2">
                                            {{ $customer->created_at->format('d M Y, h:i A') }}
                                        </td>

                                        <td class="border px-4 py-2">
                                            <a href="{{ route('admin.customers.show', $customer) }}"
                                               class="text-blue-600 hover:underline">
                                                View Details
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="border px-4 py-4 text-center text-gray-500">
                                            No customers found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $customers->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>