<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Technician Dashboard
        </h2>
    </x-slot>

    <div class="py-10" data-gsap="fade-up">
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

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-bold mb-2">
                        Welcome, Technician
                    </h3>

                    <p class="text-gray-600">
                        View assigned repair tasks, update diagnosis, record spare parts, and mark repairs as completed.
                    </p>

                    <div class="mt-4 flex flex-wrap gap-3">
                        <a href="{{ route('technician.repair-tasks.index') }}"
                           class="inline-block px-4 py-2 bg-blue-600 text-white rounded-md text-sm hover:bg-blue-700">
                            View Assigned Tasks
                        </a>

                        <a href="{{ route('notifications.index') }}"
                           class="inline-block px-4 py-2 bg-purple-600 text-white rounded-md text-sm hover:bg-purple-700">
                            View Notifications
                        </a>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6" data-gsap-stagger>
                <div class="bg-white p-6 rounded-lg shadow-sm ws-hover-lift" data-gsap-item>
                    <p class="text-sm text-gray-500">Total Assigned Tasks</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">
                        {{ $summary['total_assigned_tasks'] }}
                    </p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm ws-hover-lift" data-gsap-item>
                    <p class="text-sm text-gray-500">New Assigned Tasks</p>
                    <p class="text-3xl font-bold text-blue-600 mt-2">
                        {{ $summary['new_assigned_tasks'] }}
                    </p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm ws-hover-lift" data-gsap-item>
                    <p class="text-sm text-gray-500">Under Diagnosis</p>
                    <p class="text-3xl font-bold text-orange-600 mt-2">
                        {{ $summary['under_diagnosis_tasks'] }}
                    </p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm ws-hover-lift" data-gsap-item>
                    <p class="text-sm text-gray-500">In Repair</p>
                    <p class="text-3xl font-bold text-indigo-600 mt-2">
                        {{ $summary['in_repair_tasks'] }}
                    </p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm ws-hover-lift" data-gsap-item>
                    <p class="text-sm text-gray-500">Waiting for Parts</p>
                    <p class="text-3xl font-bold text-yellow-600 mt-2">
                        {{ $summary['waiting_for_parts_tasks'] }}
                    </p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm ws-hover-lift" data-gsap-item>
                    <p class="text-sm text-gray-500">Completed Tasks</p>
                    <p class="text-3xl font-bold text-green-600 mt-2">
                        {{ $summary['completed_tasks'] }}
                    </p>
                </div>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg" data-gsap="fade-up">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">
                        Latest Assigned Tasks
                    </h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full border border-gray-200 text-sm">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="border px-4 py-2 text-left">Repair Code</th>
                                    <th class="border px-4 py-2 text-left">Customer</th>
                                    <th class="border px-4 py-2 text-left">Device</th>
                                    <th class="border px-4 py-2 text-left">Problem</th>
                                    <th class="border px-4 py-2 text-left">Status</th>
                                    <th class="border px-4 py-2 text-left">Invoice</th>
                                    <th class="border px-4 py-2 text-left">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($latestAssignedTasks as $repairRequest)
                                    <tr>
                                        <td class="border px-4 py-2 font-semibold">
                                            {{ $repairRequest->repair_code }}
                                        </td>

                                        <td class="border px-4 py-2">
                                            {{ $repairRequest->customer->user->name }}
                                        </td>

                                        <td class="border px-4 py-2">
                                            {{ $repairRequest->device->brand }}
                                            {{ $repairRequest->device->model }}
                                        </td>

                                        <td class="border px-4 py-2">
                                            {{ \Illuminate\Support\Str::limit($repairRequest->issue_description, 50) }}
                                        </td>

                                        <td class="border px-4 py-2">
                                            <span class="px-2 py-1 rounded text-xs bg-blue-100 text-blue-700">
                                                {{ ucwords(str_replace('_', ' ', $repairRequest->status)) }}
                                            </span>
                                        </td>

                                        <td class="border px-4 py-2">
                                            @if ($repairRequest->invoice)
                                                <span class="{{ $repairRequest->invoice->status === 'paid' ? 'text-green-700' : 'text-red-700' }}">
                                                    {{ ucwords($repairRequest->invoice->status) }}
                                                </span>
                                            @else
                                                No invoice
                                            @endif
                                        </td>

                                        <td class="border px-4 py-2">
                                            <a href="{{ route('technician.repair-tasks.show', $repairRequest) }}"
                                               class="text-blue-600 hover:underline">
                                                Continue Task
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="border px-4 py-4 text-center text-gray-500">
                                            No assigned tasks found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('technician.repair-tasks.index') }}"
                           class="text-blue-600 hover:underline">
                            View all assigned tasks
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
