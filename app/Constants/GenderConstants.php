<?php

namespace App\Constants;
use App\Traits\ConstantsTrait;

enum GenderConstants : int
{
    use ConstantsTrait;

    case MALE = 1;
    case FEMALE = 2;

    public static function getLabels(): array
    {
        return [
            self::MALE->value => __json('pages.male'),
            self::FEMALE->value => __json('pages.female'),
        ];
    }

    public function label()
    {
        return self::getLabels()[$this->value];
    }
}
