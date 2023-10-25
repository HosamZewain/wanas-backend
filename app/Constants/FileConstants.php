<?php

namespace App\Constants;

use App\Traits\ConstantsTrait;

enum FileConstants: string
{
    use ConstantsTrait;

    case CIVIL_IMAGE = 'civil_image';
    case CIVIL_IMAGE_FRONT = 'civil_image_front';
    case CIVIL_IMAGE_BACK = 'civil_image_back';
    case PROFILE_IMAGE = 'profile_image';
    case VEHICLE_LOGO = 'vehicle_logo';
    case PAGE_IMAGE = 'page_image';


    public static function getLabels(): array
    {
        return [
            self::CIVIL_IMAGE->value => __json('pages.civil_image'),
            self::CIVIL_IMAGE_FRONT->value => __json('pages.civil_image_front'),
            self::CIVIL_IMAGE_BACK->value => __json('pages.civil_image_back'),
            self::PROFILE_IMAGE->value => __json('pages.profile_image'),
            self::VEHICLE_LOGO->value => __json('pages.vehicle_logo'),
            self::PAGE_IMAGE->value => __json('pages.page_image'),
        ];
    }

    public function label(){
        return self::getLabels()[$this->value];
    }

    public static function fileableTypes(): array
    {
        return [
            'User',
            'VehiclesType',
            'Page'
        ];
    }

}
