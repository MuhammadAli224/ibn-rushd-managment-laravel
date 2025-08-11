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
        ]
    ],
     "expenses" => [
        "title" => "المصروفات",
        "single" => "مصروف",
        "columns" => [
            "created_at" => "التاريخ",
            "category" => "الفئة",
            "amount" => "المبلغ",
            "description" => "الوصف",
            "wallet" => "المحفظة",
            "user" => "المستخدم",
            "confirmed" => "تم التأكيد",
            "uuid" => "الكود",
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
    ],
];
