<?php

namespace App\Constants;
use App\Traits\ConstantsTrait;

enum UserTypeConstants : int
{
    use ConstantsTrait;

    case MANAGEMENT = 1;
    case TEAM_LEADER = 2;
    case DEVELOPER = 3;
    case QUALITY_CONTROL = 4;

    public function label(): string
    {
        return self::getLabels()[$this->value];
    }

    public static function getLabels(): array
    {
        return [
            self::MANAGEMENT->value => __('pages.management'),
            self::TEAM_LEADER->value => __('pages.team_leader'),
            self::DEVELOPER->value => __('pages.developer'),
            self::QUALITY_CONTROL->value => __('pages.quality_control'),
        ];
    }
}
