<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $notifications = $user->notifications()
            ->latest()
            ->limit($request->integer('limit', 10))
            ->get()
            ->map(function ($notification) {
                $data = $notification->data ?? [];

                return [
                    'id' => $notification->id,
                    'type' => class_basename($notification->type),
                    'title' => $data['title'] ?? 'Notifikasi',
                    'message' => $data['message'] ?? null,
                    'icon' => $data['icon'] ?? 'fa-bell',
                    'severity' => $data['severity'] ?? 'info',
                    'action_url' => $data['action_url'] ?? null,
                    'read_at' => optional($notification->read_at)?->toDateTimeString(),
                    'time_ago' => $notification->created_at?->diffForHumans(),
                ];
            });

        return response()->json([
            'data' => $notifications,
            'unread_count' => $user->unreadNotifications()->count(),
        ]);
    }

    public function markAllAsRead(Request $request)
    {
        $request->user()->unreadNotifications->markAsRead();

        return response()->noContent();
    }
}
