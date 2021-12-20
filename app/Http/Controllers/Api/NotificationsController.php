<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\Api\NotificationResource;
use App\Repositories\SQL\NotificationRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class NotificationsController extends ApiBaseController
{

    private $notificationRepository;

    public function __construct(NotificationRepository $notificationRepository)
    {
        $this->notificationRepository = $notificationRepository;
    }

    public function notificationList(Request $request)
    {
        $notifications = $this->notificationRepository->search([], ['Member', 'relatedModel', 'user'], true, true, false);
        if ($notifications) {
            $resources = NotificationResource::collection($notifications);
            $resources = new LengthAwarePaginator($resources, $notifications->total(), $notifications->perPage());
            return $this->respondWithSuccess(__('messages.data_found'), $resources);
        }
        return $this->respondWithErrors(__('messages.no_data_found'), 422, null, __('messages.error'));

    }
}
