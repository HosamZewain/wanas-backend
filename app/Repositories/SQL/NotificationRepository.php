<?php

namespace App\Repositories\SQL;

use App\Models\Notification;
use App\Notifications\FcmNotification;
use App\Repositories\Contracts\NotificationContract;

class NotificationRepository extends BaseRepository implements NotificationContract
{
    /**
     * NotificationRepository constructor.
     * @param Notification $model
     */
    public function __construct(Notification $model)
    {
        parent::__construct($model);
    }

    public function afterCreate($model, $attributes)
    {
        $model->user->notify(new FcmNotification($model));
        return $model;
    }

    public function afterUpdate($model, $attributes)
    {
        $model->user->notify(new FcmNotification($model));
        return $model;
    }

    public function toggleRead(Notification $notification): void
    {
        $notification->update(['read_at' => $notification->read_at ? null : now()]);
    }

    public function markAllAsRead(): void
    {
        $this->model
            ->ofUser(auth()->id())
            ->ofUnread()
            ->update(['read_at' => now()]);
    }

    public function markAllAsUnRead(): void
    {
        $this->model
            ->ofUser(auth()->id())
            ->ofRead()
            ->update(['read_at' => null]);
    }

    public function takeAction($attributes, $model)
    {
        // all models actions

        $relatedModelContract = app("App\\Repositories\\Contracts\\{$model->redirect_type}Contract");

        match ($model->redirect_type) {
            'Leave' => $relatedModelContract->approveLeave(
                $relatedModelContract->find($model->redirect_id, ['pendingActions']),
                request()->all()
                )
        };
    }

    public function destroyAll(): void
    {
        $this->model
            ->ofUser(auth()->id())
            ->delete();
    }

}
