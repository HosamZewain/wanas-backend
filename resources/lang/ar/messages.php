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
    'register_success' => 'تم تسجيل حساب جديد بنجاح',
    'error' => 'حدث خطأ ، نأسف للإزعاج يرجى إعادة المحاولة',
    'complete_empty_values' => 'يرجى إدخال جميع البيانات و إعادة المحاولة',
    'not_active' => 'غير مفعل',
    'active' => ' نشط',
    'activated_successfully' => 'تم تنشيط الحساب بنجاح',
    'data_found' => 'تم العثور على نتائج',
    'no_data_found' => 'لم يتم العثور على نتائج',
    'account_not_active' => 'هذا الحساب غير مفعل ، يرجى تفعيل الحساب بواسطة الكود المرسل لهاتفك',
    'login_success' => 'تم تسجيل الدخول بنجاح',
    'added_success' => 'تم الحفظ بنجاح',
    'edit_success' => 'تم التعديل بنجاح',
    'cannot_add_more_than_one_vehicle' => 'لا يمكن إضافة أكثر من سيارة ',
    'trip_status' => [
        \App\Models\Trip::STATUS_ACTIVE => 'نشط',
        \App\Models\Trip::STATUS_ENDED => 'إنتهت',
    ],
    'days_array' => [
        'Sun' => 'الأحد',
        'Mon' => 'الإثنين',
        'Tue' => 'الثلاثاء',
        'Wed' => 'الأربعاء',
        'Thu' => 'الخميس',
        'Fri' => 'الجمعة',
        'Sat' => 'السبت',
    ],
    'request_sent_successfully' => 'تم إرسال طلب ونس سيتم إرسال إشعار عند موافقة المستخدم',
    'trip_added_success' => 'تم إضافة الرحلة بنجاح',
    'notifications_types' => [
        'new_trip' => '',
        'book_approved' => '',
        'book_disapproved' => '',
    ],
    'book_approved' => 'تم الموافقة على طلب حجز الرحلة',
    'book_disapproved' => 'تم رفض  طلب حجز الرحلة',
    'password_changed_successfully' => 'تم تغيير كلمة المرور بنجاح',
    'trip_complete' => 'تم إكتمال العدد فى الرحلة',

];
