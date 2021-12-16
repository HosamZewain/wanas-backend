<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\Api\NotificationResource;
use App\Repositories\SQL\NotificationRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotificationsController extends ApiBaseController
{

    private $notificationRepository;

    public function __construct(NotificationRepository $notificationRepository)
    {
        $this->notificationRepository = $notificationRepository;
    }

    public function notificationList(Request $request)
    {
        $resources = $this->notificationRepository->search([], ['Member','relatedModel','user'], false, false, false);
      //  dd($resources);
        if ($resources) {

           $resources = NotificationResource::collection($resources);
            return $this->respondWithSuccess(__('messages.data_found'), $resources);
        }
        return $this->respondWithErrors(__('messages.no_data_found'), 422, null, __('messages.error'));

    }
}
