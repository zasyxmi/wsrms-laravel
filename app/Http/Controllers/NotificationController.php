<?php

namespace App\Http\Controllers;

use App\Models\SystemNotification;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index(): View
    {
        $notifications = SystemNotification::query()
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        $unreadCount = SystemNotification::query()
            ->where('user_id', Auth::id())
            ->whereNull('read_at')
            ->count();

        return view('notifications.index', compact('notifications', 'unreadCount'));
    }

    public function markAsRead(SystemNotification $notification): RedirectResponse
    {
        abort_if($notification->user_id !== Auth::id(), 403, 'Unauthorized access.');

        if (! $notification->read_at) {
            $notification->update([
                'read_at' => now(),
            ]);
        }

        return redirect()
            ->route('notifications.index')
            ->with('success', 'Notification has been marked as read.');
    }

    public function markAllAsRead(): RedirectResponse
    {
        SystemNotification::query()
            ->where('user_id', Auth::id())
            ->whereNull('read_at')
            ->update([
                'read_at' => now(),
            ]);

        return redirect()
            ->route('notifications.index')
            ->with('success', 'All notifications have been marked as read.');
    }
}