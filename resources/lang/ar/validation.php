<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'The :attribute must be accepted.',
    'active_url' => ' حقل :attribute ليس عنوان URL صالحًا.',
    'after' => ' حقل :attribute  يجب ان يكون تاريخ بعد :date',
    'after_or_equal' => ' حقل :attribute  يجب ان يكون تاريخ مساوي او بعد تاريخ :date',
    'alpha' => 'قد تحتوي :attribute على أحرف فقط.',
    'alpha_dash' => 'لا يجوز أن تحتوي :attribute إلا على أحرف وأرقام وشرطات وشرطات سفلية.',
    'alpha_num' => 'لا يجوز أن تحتوي :attribute إلا على أحرف وأرقام.',
    'array' => 'يجب أن تكون :attribute مصفوفة.',
    'before' => 'يجب أن يكون :attribute تاريخًا قبل date: .',
    'before_or_equal' => ' حقل :attribute  يجب ان يكون تاريخ مساوي او قبل تاريخ :date',
    'between' => [
        'numeric' => 'حقل :attribute يجب ان يكون بين min: و max:',
        'file' => 'يجب أن يكون :attribute بين min: و max: كيلوبايت.',
        'string' => 'يجب أن يكون :attribute بين min: و max: حرفا.',
        'array' => 'يجب أن يكون :attribute بين min: و max: عناصر.',
    ],
    'boolean' => 'يجب أن يكون حقل :attribute صح أو خطأ.',
    'confirmed' => 'تأكيد :attribute غير مطابق.',
    'date' => 'حقل :attribute ليست تاريخًا صالحًا.',
    'date_equals' => ' حقل :attribute  يجب ان يكون تاريخ مساوي :date',
    'date_format' => 'حقل :attribute لا تطابق التنسيق  format: .',
    'different' => 'يجب ان يكون حقل :attribute و other: مختلفين',
    'digits' => 'يجب أن تكون :attribute و digits: أرقامًا.',
    'digits_between' => 'يجب أن يكون :attribute بين min: و max: .',
    'dimensions' => 'حقل :attribute له ابعاد صورة غير صالحة .',
    'distinct' => 'يحتوي حقل :attribute على قيمة مكررة.',
    'email' => 'حقل :attribute يجب أن يكون بصيغة صحيحة.',
    'ends_with' => '   حقل :attribute يجب ان ينتهي بواحده من values:',
    'exists' => 'حقل :attribute المختار غير صالح',
    'file' => 'حقل :attribute يجب ان يكون ملف',
    'filled' => 'حقل :attribute يجب ان يحتوي على قيمة',
    'gt' => [
        'numeric' => 'حقل :attribute يجب ان تكون اكبر من :value.',
        'file' => 'حقل :attribute يجب ان تكون اكبر من :value كيلو بايت.',
        'string' => 'حقل :attribute يجب ان تكون اكبر من  :value حروف.',
        'array' => 'حقل :attribute يجب أن يكون أكثر من :value عناصر.',
    ],
    'gte' => [
        'numeric' => 'حقل :attribute يجب أن يكون أكبر من أو يساوي  :value.',
        'file' => 'حقل :attribute يجب أن يكون أكبر من أو يساوي  :value  كيلو بايت.',
        'string' => 'حقل :attribute يجب أن يكون أكبر من أو يساوي  :value حروف.',
        'array' => 'حقل :attribute يجب أن يكون    :value من العناصر أو أكثر.',
    ],
    'image' => 'حقل :attributeيجب أن تكون صورة.',
    'in' => 'الحقل المحدد :attribute غير صالح.',
    'in_array' => 'حقل :attribute الحقل غير موجود في :other.',
    'integer' => 'حقل :attribute يجب أن يكون صحيحا.',
    'ip' => 'حقل :attribute يجب أن يكون عنوان IP صالحًا.',
    'ipv4' => 'حقل :attribute يجب أن يكون عنوان IPv4 صالحًا.',
    'ipv6' => 'حقل :attribute يجب أن يكون عنوان IPv6 صالحًا.',
    'json' => 'حقل :attribute يجب أن تكون سلسلة JSON صالحة.',
    'lt' => [
        'numeric' => 'حقل :attribute يجب أن يكون أقل من :value.',
        'file' => 'حقل :attribute يجب أن يكون أقل من :value  كيلو بايت.',
        'string' => 'حقل :attribute يجب أن يكون أقل من :value حروف.',
        'array' => 'حقل :attribute يجب أن يكون أقل من :value عناصر.',
    ],
    'lte' => [
        'numeric' => 'حقل :attribute يجب أن يكون أصغر من أو يساوي :value.',
        'file' => 'حقل :attribute يجب أن يكون أصغر من أو يساوي :value كيلو بايت.',
        'string' => 'حقل :attribute يجب أن يكون أصغر من أو يساوي :value حروف.',
        'array' => 'حقل :attribute يجب ألا يحتوي على أكثر من :value عناصر.',
    ],
    'max' => [
        'numeric' => 'حقل :attribute قد لا يكون أكبر من :max.',
        'file' => 'حقل :attribute قد لا يكون أكبر من :max كيلو بايت.',
        'string' => 'حقل :attribute قد لا يكون أكبر من :max حروف.',
        'array' => 'حقل :attribute قد لا يكون أكثر من :max عناصر.',
    ],
    'mimes' => 'حقل :attribute يجب أن يكون ملف type: :values.',
    'mimetypes' => 'حقل :attribute يجب أن يكون ملفtype: :values.',
    'min' => [
        'numeric' => 'حقل :attribute يجب أن يكون على الأقل :min.',
        'file' => 'حقل :attribute يجب أن يكون على الأقل :min كيلو بايت.',
        'string' => 'حقل :attribute يجب أن يكون على الأقل :min حروف.',
        'array' => 'حقل :attribute يجب أن يكون على الأقل :minعناصر.',
    ],
    'not_in' => 'الحقل المحدد :attribute غير صالح.',
    'not_regex' => 'حقل :attribute التنسيق غير صالح.',
    'numeric' => 'حقل :attribute يجب أن يكون رقما.',
    'present' => 'حقل :attribute يجب أن يكون الحقل موجودًا.',
    'regex' => 'حقل :attribute التنسيق غير صالح.',
    'required' => 'حقل :attribute مطلوب.',
    'required_if' => 'حقل :attribute مطلوب.',
    'required_unless' => 'حقل :attribute الحقل مطلوب ما لم يكن :other في داخل :values.',
    'required_with' => 'حقل :attribute الحقل مطلوب عندما :values موجود.',
    'required_with_all' => 'حقل :attribute الحقل مطلوب عندما :values موجود.',
    'required_without' => 'حقل :attribute الحقل مطلوب عندما :values غير موجود.',
    'required_without_all' => 'حقل :attribute الحقل مطلوبًا في حالة عدم وجود أي من :values موجود.',
    'same' => 'حقل :attribute و :other يجب أن تتطابق.',
    'size' => [
        'numeric' => 'حقل :attribute يجب ان يكون :size.',
        'file' => 'حقل :attribute يجب أن يكون :size كيلو بايت.',
        'string' => 'حقل :attribute يجب أن يكون :size رموز.',
        'array' => 'حقل :attribute يجب أن تحتوي على :size حروف.',
    ],
    'starts_with' => 'حقل :attribute يجب أن يبدأ بواحد مما يلي: :values',
    'string' => 'حقل :attribute يجب أن يكون سلسلة.',
    'timezone' => 'حقل :attribute يجب أن تكون منطقة صالحة.',
    'unique' => ':attribute مسجل من قبل فى النظام.',
    'uploaded' => 'حقل :attribute فشل التحميل.',
    'url' => 'حقل :attribute التنسيق غير صالح.',
    'uuid' => 'حقل :attribute يجب أن يكون UUID صالحًا.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'student_civil_id' => [
            'unique' => ':attribute مسجلة بالفعل لطالب فى بيانات المدرسة',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        'email' => 'البريد الالكتروني',
        'password' => 'كلمة المرور',
        'name' => 'الاسم',
        'number' => 'الرقم',
        'color' => 'اللون',
        'year_levels' => 'المراحل الدراسية',
        'year_level' => 'المرحلة الدراسية',
        'lang' => 'اللغة',
        'phone' => 'الهاتف',
        'address' => 'العنوان',
        'courses' => 'المناهج الدراسية',
        'classrooms' => 'الغرف الدراسية',
        'subjects' => 'المواد الدراسية',
        'classes' => 'الصفوف الدراسية',
        'max_periods' => 'عدد الحصص',
        'weekly_working_days' => 'عدد أيام العمل',
        'work_period_length' => 'مدة الحصة',
        'break_period_length' => 'مدة الفسحة',
        'school' => 'المدرسة',
        'permissions' => 'الصلاحيات',
        'role' => 'المجموعة',
        'from' => 'من تاريخ',
        'to' => 'الى تاريخ',
        'new_logo' => 'الشعار',
        'username' => 'اسم المستخدم',
        'mobile' => 'الموبايل',
        'type' => 'النوع',
        'subject' => 'الموضوع',
        'body' => 'محتوى الرسالة',
        'cr_password' => 'كلمة المرور الحالية',
        'class' => 'الصف الدراسي',
        'start_date' => 'تاريخ البداية',
        'from_time' => 'من وقت',
        'to_time' => 'إلى وقت',
        'governorates_id' => 'المحافظة',
        'name_ar' => 'الاسم عربى',
        'name_en' => 'الاسم انجليزى',
    ],

    'invalid_data'    => 'البيانات المدخلة كانت خاطئة',
    'empty_first_day' => 'يرجى تحديد بداية أيام العمل',
    'no_working_days' => 'يرجى تحديد أيام العمل',
    'max_degree_must'=>'يجب ألا تتجاوز الدرجة : ',
    'student_civil_id_digits'=> 'يجب أن تكون البطاقة المدنية للطالب 12 رقمًا',

];
