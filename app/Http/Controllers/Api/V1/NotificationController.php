<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\NotificationRequest;
use App\Http\Resources\NotificationResource;
use App\Models\Notification;
use App\Repositories\Contracts\NotificationContract;
use Exception;
use \Illuminate\Http\JsonResponse;

class NotificationController extends BaseApiController
{
    /**
     * NotificationController constructor.
     * @param NotificationContract $repository
     */
    public function __construct(NotificationContract $repository)
    {
        parent::__construct($repository, NotificationResource::class, 'Notification');
    }

    public function destroy(Notification $notification): JsonResponse
    {
        try {
            $this->repository->remove($notification);
            return $this->respondWithSuccess(__('messages.deleted'));
        }catch (Exception $e) {
            return $this->respondWithError($e->getMessage());
        }
    }

    public function toggleRead(Notification $notification): JsonResponse
    {
        try {
            $this->repository->toggleRead($notification);
            return $this->respondWithSuccess(__('messages.updated'));
        }catch (Exception $e) {
            return $this->respondWithError($e->getMessage());
        }
    }

    public function markAllAsRead(): JsonResponse
    {
        try {
            $this->repository->markAllAsRead();
            return $this->respondWithSuccess(__('messages.updated'));
        }catch (Exception $e) {
            return $this->respondWithError($e->getMessage());
        }
    }

    public function markAllAsUnRead(): JsonResponse
    {
        try {
            $this->repository->markAllAsUnRead();
            return $this->respondWithSuccess(__('messages.updated'));
        }catch (Exception $e) {
            return $this->respondWithError($e->getMessage());
        }
    }

    public function takeAction(Notification $notification, NotificationRequest $request): JsonResponse
    {
        try {
            $this->repository->takeAction($request->validated(), $notification);
            return $this->respondWithSuccess(__('messages.updated'));
        }catch (Exception $e) {
            return $this->respondWithError($e->getMessage());
        }
    }

    public function destroyAll(): JsonResponse
    {
        try {
            $this->repository->destroyAll();
            return $this->respondWithSuccess(__('messages.deleted'));
        }catch (Exception $e) {
            return $this->respondWithError($e->getMessage());
        }
    }
}
