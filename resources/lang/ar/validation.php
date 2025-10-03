<?php


return [
    'failed' => 'فشل التحقق من البيانات. الرجاء مراجعة البيانات المرسلة.',
    'name_string' => 'يجب أن يكون الاسم نصًا.',
    'email_valid' => 'يجب أن يكون البريد الإلكتروني صالحًا.',
    'email_unique' => 'هذا البريد الإلكتروني مستخدم بالفعل.',
    'phone_unique' => 'رقم الهاتف هذا مستخدم بالفعل.',
    'password_min' => 'يجب أن تكون كلمة المرور 6 أحرف على الأقل.',
    'password_confirmed' => 'تأكيد كلمة المرور غير متطابق.',
    'tax_number_unique' => 'رقم الضريبة هذا مستخدم بالفعل.',
    'comerical_number_unique' => 'رقم السجل التجاري هذا مستخدم بالفعل.',
    'name_required' => 'الاسم مطلوب.',
    'email_required' => 'البريد الإلكتروني مطلوب.',
    'phone_required' => 'رقم الهاتف مطلوب.',
    'password_required' => 'كلمة المرور مطلوبة.',
    'user_id_required' => 'المستخدم مطلوب.',
    'user_id_exists' => 'المستخدم غير موجود.',


    'tax_number_required' => 'الرقم الضريبي مطلوب.',
    'tax_number_string' => 'يجب أن يكون الرقم الضريبي نصًا.',

    'comerical_number_required' => 'الرقم التجاري مطلوب.',
    'comerical_number_string' => 'يجب أن يكون الرقم التجاري نصًا.',

    'image_image' => 'يجب أن يكون الملف صورة.',
    'image_mimes' => 'يجب أن تكون الصورة من نوع: jpg أو jpeg أو png.',
    'image_max' => 'يجب ألا تتجاوز الصورة 2 ميغابايت.',

    'branch_id.required' => 'الفرع مطلوب',
    'branch_id.exists' => 'الفرع غير موجود',


    'required' => 'حقل :attribute مطلوب.',
    'email' => ':attribute يجب أن يكون بريدًا إلكترونيًا صالحًا.',
    'unique' => ':attribute موجود بالفعل.',
    'confirmed' => 'تأكيد :attribute غير متطابق.',
    'string' => ':attribute يجب أن يكون نصًا.',
    'max' => [
        'string' => 'يجب ألا يزيد :attribute عن :max حرفًا.',
    ],
    'min' => [
        'string' => 'يجب ألا يقل :attribute عن :min حرفًا.',
    ],

    'attributes' => [
        'name' => 'الاسم',
        'email' => 'البريد الإلكتروني',
        'phone' => 'رقم الهاتف',
        'password' => 'كلمة المرور',
        'tax_number' => 'الرقم الضريبي',
        'comerical_number' => 'الرقم التجاري',
        'name_ar' => 'الاسم بالعربية',
        'name_en' => 'الاسم بالإنجليزية',
    ],


    'product' => [
        'name_required' => 'اسم المنتج مطلوب',
        'name_string' => 'اسم المنتج يجب أن يكون نصاً',
        'name_max' => 'اسم المنتج طويل جداً',
        'price_required' => 'السعر مطلوب',
        'price_numeric' => 'السعر يجب أن يكون رقمًا',
        'cost_required' => 'التكلفة مطلوبة',
        'cost_numeric' => 'التكلفة يجب أن تكون رقمًا',
        'unit_required' => 'الوحدة مطلوبة',
        'unit_string' => 'الوحدة يجب أن تكون نصاً',
        'unit_max' => 'الوحدة طويلة جداً',
        'image_image' => 'الصورة يجب أن تكون صورة صالحة',
        'image_mimes' => 'الصورة يجب أن تكون من نوع jpg أو png أو jpeg',
        'image_max' => 'الصورة كبيرة جداً',
        'product_no_required' => 'رقم المنتج مطلوب',
        'product_no_integer' => 'رقم المنتج يجب أن يكون رقمًا صحيحًا',
        'product_no_unique' => 'رقم المنتج مستخدم من قبل',
        'category_id_required' => 'التصنيف مطلوب',
        'category_id_exists' => 'التصنيف غير موجود',
        'payment_type_required' => 'نوع الدفع مطلوب',
        'payment_type_in' => 'نوع الدفع غير صالح',
        'branches_required' => 'الفرع مطلوب',
        'branches_array' => 'البيانات المرسلة للفروع غير صحيحة',
        'branch_id_required' => 'رقم الفرع مطلوب',
        'branch_id_exists' => 'الفرع غير موجود',
        'quantity_required' => 'الكمية مطلوبة',
        'quantity_integer' => 'الكمية يجب أن تكون رقمًا صحيحًا',
        'is_active_boolean' => 'حقل التفعيل يجب أن يكون true أو false',
        'is_most_popular_boolean' => 'الحقل المفضل يجب أن يكون true أو false',
        'status_in' => 'الحالة يجب أن تكون إما "active" أو "inactive"',
    ],


    'category' => [
        'name_required' => 'اسم القسم مطلوب.',
        'name_array' => 'حقل الاسم يجب أن يكون من نوع مصفوفة.',
        'name_ar_required' => 'الاسم باللغة العربية مطلوب.',
        'name_en_required' => 'الاسم باللغة الإنجليزية مطلوب.',
        'branch_id_required' => 'الفرع مطلوب.',
        'branch_id_exists' => 'الفرع المحدد غير صالح.',
    ],

    'login_required' => 'حقل تسجيل الدخول مطلوب.',

    'failed' => 'فشل التحقق من البيانات.',
    
    'subject_string' => 'المادة يجب أن تكون نصًا.',
    'subject_min'    => 'المادة يجب أن تكون على الأقل 3 أحرف.',
    'subject_max'    => 'المادة لا يمكن أن تتجاوز 100 حرف.',

    'lesson_date_valid' => 'تاريخ الدرس يجب أن يكون تاريخًا صحيحًا.',

    'lesson_start_format' => 'وقت بدء الدرس يجب أن يكون بالصيغة HH:MM.',
    'lesson_end_format'   => 'وقت نهاية الدرس يجب أن يكون بالصيغة HH:MM.',
    'lesson_end_after'    => 'وقت نهاية الدرس يجب أن يكون بعد وقت البداية.',

    'lesson_location_string' => 'موقع الدرس يجب أن يكون نصًا.',
    'lesson_location_max'    => 'موقع الدرس لا يمكن أن يتجاوز 255 حرفًا.',

    'lesson_notes_string' => 'ملاحظات الدرس يجب أن تكون نصًا.',

    'lesson_duration_integer' => 'مدة الدرس يجب أن تكون عددًا صحيحًا.',
    'lesson_duration_min'     => 'مدة الدرس يجب أن تكون دقيقة واحدة على الأقل.',

    'checkin_format'  => 'وقت تسجيل الدخول يجب أن يكون بالصيغة HH:MM.',
    'checkout_format' => 'وقت تسجيل الخروج يجب أن يكون بالصيغة HH:MM.',
    'checkout_after'  => 'وقت تسجيل الخروج يجب أن يكون بعد تسجيل الدخول.',

    'lesson_price_numeric' => 'سعر الدرس يجب أن يكون رقمًا.',
    'lesson_price_min'     => 'سعر الدرس يجب أن يكون 0 أو أكثر.',

    'status_invalid' => 'حالة الدرس غير صحيحة.',

    'attributes' => [
        'subject'         => 'المادة',
        'lessonDate'      => 'تاريخ الدرس',
        'lessonStartTime' => 'وقت بدء الدرس',
        'lessonEndTime'   => 'وقت نهاية الدرس',
        'lessonLocation'  => 'موقع الدرس',
        'lessonNotes'     => 'ملاحظات الدرس',
        'lessonDuration'  => 'مدة الدرس',
        'checkInTime'     => 'وقت تسجيل الدخول',
        'checkOutTime'    => 'وقت تسجيل الخروج',
        'lessonPrice'     => 'سعر الدرس',
        'status'          => 'الحالة',
    ],
];
