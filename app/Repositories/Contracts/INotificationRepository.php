<?php

namespace App\Repositories\Contracts;

interface INotificationRepository extends IModelRepository
{

    public function sendNotification($user, $body = null, string $title = 'Wanes', array $paramters = []);
}
