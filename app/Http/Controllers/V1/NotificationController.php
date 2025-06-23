<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    use ApiResponseTrait;
    public function index()
    {
        $user = auth()->user();
        $notifications = $user->notifications()->latest()->paginate(15);


        return $this->successPagination(
            data: NotificationResource::collection($notifications),
            message: __('general.get_success')
        );
    }
    public function markAsRead($id)
    {
        $user = auth()->user();
        $notification = $user->unreadNotifications()->find($id);

        if (!$notification) {
            return $this->error(
                __('notification.notification_not_found'),
                __('notification.notification_not_found'),
                404,
            );
        }

        $notification->markAsRead();

        return $this->success(
            message: __('notification.marked_as_read')
        );
    }
    public function markAllAsRead()
    {
        $user = auth()->user();
        $user->unreadNotifications->markAsRead();

        return $this->success(
            message: __('notification.marked_all_as_read')
        );
    }
}
