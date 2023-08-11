<?php

namespace App\Http\Controllers\App;

use App\Models\User;
use App\Models\UserNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class NotificationController extends AppController
{
    public function myNotifications(Request $request, User $user): JsonResponse
    {
        $notifications = QueryBuilder::for(UserNotification::class)
            ->whereHas('user', function ($query) use ($user) {
                $query->where('id', $user->id);
            })
            ->with('notification')
            ->paginate($request->per_page);
        return $this->response(true, $notifications, 'my notifications');
    }
}
