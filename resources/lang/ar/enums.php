<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'trip_status_list' => [
        \App\Models\Trip::STATUS_ACTIVE => 'نشط',
        \App\Models\Trip::STATUS_ENDED => 'منتهى',
    ],


    'vehicle_status_list' => [
        \App\Models\UserVehicle::STATUS_IN_PROGRESS => 'جارى المراجعة',
        \App\Models\UserVehicle::STATUS_APPROVED => 'تمت تأكيد البيانات',
        \App\Models\UserVehicle::STATUS_DISAPPROVED => 'تم رفض الطلب',
    ],

    'attachment_keys' => [
        'civil_image_back' => 'خلفية البطاقة الشخصية',
        'civil_image_front' => 'واجهة البطاقة الشخصية',
        'profile_image' => ' الصورة الشخصية',
        'car_back' => 'خلفية  السيارة',
        'car_front' => 'واجهة  السيارة',
        'car_near' => 'صورة جانبية  للسيارة',
    ],
    'attachment_status' => [
        \App\Models\Attachment::STATUS_APPROVED => 'تم الموافقة والتأكيد',
        \App\Models\Attachment::STATUS_DISAPPROVED => 'تم الرفض ',
        \App\Models\Attachment::STATUS_UPLOADED => 'تم الرفع',
    ],
    'members_status' => [
        \App\Models\TripMember::STATUS_APPROVED => 'تم الموافقة والتأكيد',
        \App\Models\TripMember::STATUS_WAITING_APPROVAL => 'جارى المعالجة  ',
        \App\Models\TripMember::STATUS_DISAPPROVED => 'تم الرفض',
    ],
    'attachment_status_' . \App\Models\Attachment::STATUS_APPROVED => 'تم الموافقة والتأكيد',
    'attachment_status_' . \App\Models\Attachment::STATUS_DISAPPROVED => 'تم الرفض ',
    'attachment_status_' . \App\Models\Attachment::STATUS_UPLOADED => 'تم الرفع',

];
