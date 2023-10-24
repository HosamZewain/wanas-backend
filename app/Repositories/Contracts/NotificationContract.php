<?php

namespace App\Repositories\Contracts;

use App\Models\Notification;

interface NotificationContract extends BaseContract
{
    public function toggleRead(Notification $notification): void;

    public function markAllAsRead(): void;

    public function markAllAsUnRead(): void;

    public function takeAction($attributes, $model);

    public function destroyAll(): void;
}

