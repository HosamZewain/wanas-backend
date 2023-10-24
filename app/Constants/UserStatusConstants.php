<?php

namespace App\Constants;
use App\Traits\ConstantsTrait;

enum UserStatusConstants : int
{
    use ConstantsTrait;

    case APPROVED = 1;
    case NOT_APPROVED = 2;

    public static function getLabels(): array
    {
        return [
            self::APPROVED->value => __json('pages.approved'),
            self::NOT_APPROVED->value => __json('pages.not_approved'),
        ];
    }
}
