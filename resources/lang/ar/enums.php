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


];
