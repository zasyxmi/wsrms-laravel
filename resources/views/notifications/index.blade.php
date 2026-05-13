<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Notifications
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    You have {{ $unreadCount }} unread notification(s).
                </p>
            </div>

            <a href="{{ route('dashboard') }}"
               class="px-4 py-2 bg-gray-600 text-white rounded-md text-sm hover:bg-gray-700">
                Back to Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">

                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-bold text-gray-900">
                            Notification List
                        </h3>

                        @if ($unreadCount > 0)
                            <form method="POST"
                                  action="{{ route('notifications.mark-all-as-read') }}">
                                @csrf
                                @method('PATCH')

                                <button type="submit"
                                        class="px-4 py-2 bg-blue-600 text-white rounded-md text-sm hover:bg-blue-700">
                                    Mark All as Read
                                </button>
                            </form>
                        @endif
                    </div>

                    <div class="space-y-4">
                        @forelse ($notifications as $notification)
                            <div class="border rounded-lg p-4 {{ $notification->read_at ? 'bg-white' : 'bg-blue-50 border-blue-200' }}">
                                <div class="flex items-start justify-between gap-4">

                                    <div>
                                        <div class="flex items-center gap-2">
                                            <h4 class="font-semibold text-gray-900">
                                                {{ $notification->title }}
                                            </h4>

                                            @if (! $notification->read_at)
                                                <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-700">
                                                    New
                                                </span>
                                            @endif
                                        </div>

                                        <p class="text-gray-700 mt-2">
                                            {{ $notification->message }}
                                        </p>

                                        <div class="text-sm text-gray-500 mt-3">
                                            <p>
                                                Type:
                                                <span class="font-medium">
                                                    {{ ucwords($notification->type) }}
                                                </span>
                                            </p>

                                            <p>
                                                Received:
                                                {{ $notification->created_at->format('d M Y, h:i A') }}
                                            </p>

                                            @if ($notification->read_at)
                                                <p>
                                                    Read:
                                                    {{ $notification->read_at->format('d M Y, h:i A') }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>

                                    @if (! $notification->read_at)
                                        <form method="POST"
                                              action="{{ route('notifications.mark-as-read', $notification) }}">
                                            @csrf
                                            @method('PATCH')

                                            <button type="submit"
                                                    class="px-3 py-2 bg-gray-700 text-white rounded-md text-xs hover:bg-gray-800">
                                                Mark as Read
                                            </button>
                                        </form>
                                    @endif

                                </div>
                            </div>
                        @empty
                            <div class="text-center py-10 text-gray-500">
                                No notifications found.
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-6">
                        {{ $notifications->links() }}
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>