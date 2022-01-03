<?php

namespace App\Repositories\Contracts;

interface INotificationRepository extends IModelRepository
{

    public function sentAPNS($user, $body = null, string $title = 'Wanes', array $paramters = []);
}
