<?php

return [
    "group" => "المحفظة",
    "groupName" => "إدارة مالية للمركز",
    "transactions" => [
        "title" => "المعاملات",
        "single" => "معاملة",
        "columns" => [
            "created_at" => "التاريخ",
            "user" => "المستخدم",
            "wallet" => "اسم المحفظة",
            "amount" => "المبلغ",
            "type" => "النوع",
            "balance" => "الرصيد",
            "description" => "الوصف",
            "confirmed" => "تأكيد",
            "uuid" => "الكود",
        ],
        "filters" => [
            "accounts" => "تصفية حسب الحسابات",
        ]
    ],
    "wallets" => [
        "title" => "المحافظ",
        "columns" => [
            "created_at" => "التاريخ",
            "user" => "المستخدم",
            "name" => "الاسم",
            "balance" => "الرصيد",
            "credit" => "إيداع",
            "debit" => "سحب",
            "uuid" => "الكود",
        ],
        "action" => [
            "title" => "تحويلات المحفظة",
            "current_balance" => "الرصيد الحالي",
            "credit" => "إيداع",
            "debit" => "سحب",
            "type" => "النوع",
            "amount" => "المبلغ",
        ],
        "filters" => [
            "accounts" => "تصفية حسب الحسابات",
        ],
        "notification" => [
            "title" => "تمت العملية بنجاح",
            "message" => " تم تحديث رصيد المحفظة بنجاح.",
        ]
    ],
    "expenses" => [
        "title" => "المصروفات",
        "single" => "مصروف",
        "export" => "تصدير المصروفات",
        "columns" => [
            "created_at" => "التاريخ",
            "category" => "الفئة",
            "amount" => "المبلغ",
            "description" => "الوصف",
            "wallet" => "المحفظة",
            "user" => "المستخدم",
            "confirmed" => "تم التأكيد",
            "uuid" => "الكود",
            "today" => "اليوم",
            "this_month" => "هذا الشهر",
            "specific_date" => "تاريخ محدد",
            'total' => "الإجمالي",
        ],
        "filters" => [
            "category" => "تصفية حسب الفئة",
            "wallet" => "تصفية حسب المحفظة",
            "date_range" => "تصفية حسب النطاق الزمني",
        ],
        "actions" => [
            "create" => "إضافة مصروف جديد",
            "edit" => "تعديل المصروف",
            "delete" => "حذف المصروف",
        ],
        "form" => [
            "category" => "الفئة",
            "amount" => "المبلغ",
            "description" => "الوصف",
            "wallet" => "المحفظة",
            "date" => "التاريخ",
        ],
        "widgets" => [
            "expenses_overview" => [
                "title" => "نظرة عامة على المصروفات",
                "description" => "عرض إجمالي المصروفات اليوم، هذا الشهر، أو لتاريخ محدد.",
                "today" => "إجمالي مصروفات اليوم",
                "this_month" => "إجمالي مصروفات هذا الشهر",
                "this_week" => "إجمالي مصروفات هذا الأسبوع",
                "specific_date" => "إجمالي مصروفات التاريخ المحدد",
            ],
            "expenses_title" => [
                "today" => "المصروفات اليومية",
                "this_month" => "المصروفات الشهرية",
                "this_week" => "المصروفات الأسبوعية",
            ],
        ],

    ],


    "balance" => [
        "title" => "الأرصدة",
        "single" => "رصيد",
        "export" => "تصدير الأرصدة",
        "columns" => [
            "created_at" => "التاريخ",
            "category" => "الفئة",
            "amount" => "المبلغ",
            "description" => "الوصف",
            "wallet" => "المحفظة",
            "user" => "المستخدم",
            "confirmed" => "تم التأكيد",
            "uuid" => "الكود",
            "today" => "اليوم",
            "this_month" => "هذا الشهر",
            "specific_date" => "تاريخ محدد",
            'total' => "الإجمالي",
            'month' => "الشهر",
        ],
        "filters" => [
            "category" => "تصفية حسب الفئة",
            "wallet" => "تصفية حسب المحفظة",
            "date_range" => "تصفية حسب النطاق الزمني",
        ],
      
        "form" => [
            "category" => "الفئة",
            "amount" => "المبلغ",
            "description" => "الوصف",
            "wallet" => "المحفظة",
            "date" => " التاريخ",
        ],
        "widgets" => [
            "balance_overview" => [
                "title" => "نظرة عامة على الأرصدة",
                "description" => "عرض إجمالي الأرصدة اليوم، هذا الشهر، أو لشهر محدد.",

                "this_month" => "إجمالي الأرصدة لهذا الشهر",

                "specific_month" => "إجمالي الأرصدة للشهر المحدد",
            ],
            "balance_title" => [
                "this_month" => "الأرصدة الشهرية",
            ],
        ],
    ],

     "salary" => [
        "title" => "الرواتب",
        "single" => "راتب",
        "export" => "تصدير الرواتب",
        "calculate_salary" => "حساب الرواتب",
        "columns" => [
            "created_at" => "التاريخ",
            "user" => "الموظف",
            "amount" => "المبلغ",
            "type" => "نوع الراتب",
            "salary_date" => "تاريخ الراتب",
            "month" => "الشهر",
            "is_paid" => "تم الدفع",
            "payment_method" => "طريقة الدفع",
            "transaction_id" => "رقم العملية",
            "notes" => "ملاحظات",
            "center_commission_value" => "قيمة عمولة المركز",
            "center_commission_percentage" => "نسبة عمولة المركز",
            "uuid" => "الكود",
            "today" => "اليوم",
            "this_month" => "هذا الشهر",
            "specific_date" => "تاريخ محدد",
            "total" => "الإجمالي",
            "center_commession_value" => "قيمة عمولة المركز",
            "center_commession_percentage" => "نسبة عمولة المركز",
        ],
        "filters" => [
            "user" => "تصفية حسب الموظف",
            "type" => "تصفية حسب نوع الراتب",
            "month" => "تصفية حسب الشهر",
            "date_range" => "تصفية حسب النطاق الزمني",
            "is_paid" => "تصفية حسب حالة الدفع",
        ],
        "actions" => [
            "create" => "إضافة راتب جديد",
            "edit" => "تعديل الراتب",
            "delete" => "حذف الراتب",
            "mark_as_paid" => "تعيين كمدفوع",
        ],
        "form" => [
            "user" => "الموظف",
            "amount" => "المبلغ",
            "type" => "نوع الراتب",
            "salary_date" => "تاريخ الراتب",
            "month" => "الشهر",
            "is_paid" => "تم الدفع",
            "payment_method" => "طريقة الدفع",
            "transaction_id" => "رقم العملية",
            "notes" => "ملاحظات",
            "center_commission_value" => "قيمة عمولة المركز",
            "center_commission_percentage" => "نسبة عمولة المركز",
        ],
        "widgets" => [
            "salary_overview" => [
                "title" => "نظرة عامة على الرواتب",
                "description" => "عرض إجمالي الرواتب لهذا الشهر، اليوم، أو لشهر محدد.",
                "this_month" => "إجمالي الرواتب لهذا الشهر",
                "specific_month" => "إجمالي الرواتب للشهر المحدد",
                "today" => "إجمالي الرواتب اليوم",
            ],
            "salary_title" => [
                "this_month" => "الرواتب الشهرية",
            ],
        ],
        "notifications" => [
            "paid_success" => [
                "title" => "تم الدفع بنجاح",
                "message" => "تم تحديث حالة الراتب إلى مدفوع بنجاح.",
            ],
            "created_success" => [
                "title" => "تمت الإضافة بنجاح",
                "message" => "تمت إضافة الراتب الجديد بنجاح.",
            ],
            "updated_success" => [
                "title" => "تم التحديث بنجاح",
                "message" => "تم تحديث بيانات الراتب بنجاح.",
            ],
            "deleted_success" => [
                "title" => "تم الحذف بنجاح",
                "message" => "تم حذف الراتب بنجاح.",
            ],
        ],
    ],

    "incoming" => [
        "title" => "الإيرادات",
        "single" => "إيراد",
        "export" => "تصدير الإيرادات",
        "columns" => [
            "created_at" => "التاريخ",
            "category" => "الفئة",
            "amount" => "المبلغ",
            "description" => "الوصف",
            "wallet" => "المحفظة",
            "user" => "المستخدم",
            "confirmed" => "تم التأكيد",
            "uuid" => "الكود",
            "today" => "اليوم",
            "this_month" => "هذا الشهر",
            "specific_date" => "تاريخ محدد",
            "total" => "الإجمالي",
            "source" => "المصدر",
        ],
        "filters" => [
            "category" => "تصفية حسب الفئة",
            "wallet" => "تصفية حسب المحفظة",
            "date_range" => "تصفية حسب النطاق الزمني",
        ],
        "actions" => [
            "create" => "إضافة إيراد جديد",
            "edit" => "تعديل الإيراد",
            "delete" => "حذف الإيراد",
        ],
        "form" => [
            "category" => "الفئة",
            "amount" => "المبلغ",
            "description" => "الوصف",
            "wallet" => "المحفظة",
            "date" => "التاريخ",
            "source" => "المصدر",
        ],
        "widgets" => [
            "incoming_overview" => [
                "title" => "نظرة عامة على الإيرادات",
                "description" => "عرض إجمالي الإيرادات اليوم، هذا الشهر، أو لتاريخ محدد.",
                "today" => "إجمالي الإيرادات اليوم",
                "this_month" => "إجمالي الإيرادات هذا الشهر",
                "this_week" => "إجمالي الإيرادات هذا الأسبوع",
                "specific_date" => "إجمالي الإيرادات للتاريخ المحدد",
            ],
            "incoming_title" => [
                "today" => "الإيرادات اليومية",
                "this_month" => "الإيرادات الشهرية",
                "this_week" => "الإيرادات الأسبوعية",
            ],
        ],
        "notifications" => [
            "created_success" => [
                "title" => "تمت الإضافة بنجاح",
                "message" => "تمت إضافة الإيراد الجديد بنجاح.",
            ],
            "updated_success" => [
                "title" => "تم التحديث بنجاح",
                "message" => "تم تحديث بيانات الإيراد بنجاح.",
            ],
            "deleted_success" => [
                "title" => "تم الحذف بنجاح",
                "message" => "تم حذف الإيراد بنجاح.",
            ],
        ],
    ],
];
