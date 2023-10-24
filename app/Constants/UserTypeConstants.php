<?php

namespace App\Constants;
use App\Traits\ConstantsTrait;

enum UserTypeConstants : int
{
    use ConstantsTrait;

    case CLIENT = 1;
    case ADMIN = 2;

    public static function getLabels(): array
    {
        return [
            self::CLIENT->value => __json('pages.client'),
            self::ADMIN->value => __json('pages.admin'),
        ];
    }
}
