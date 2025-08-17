<?php

return [
    "group" => "Wallet",
    "groupName" => "Financial Management",

    "transactions" => [
        "title" => "Transactions",
        "single" => "Transaction",
        "columns" => [
            "created_at" => "Date",
            "user" => "User",
            "wallet" => "Wallet Name",
            "amount" => "Amount",
            "type" => "Type",
            "balance" => "Balance",
            "description" => "Description",
            "confirmed" => "Confirmed",
            "uuid" => "Code",
        ],
        "filters" => [
            "accounts" => "Filter by Accounts",
        ]
    ],

    "wallets" => [
        "title" => "Wallets",
        "columns" => [
            "created_at" => "Date",
            "user" => "User",
            "name" => "Name",
            "balance" => "Balance",
            "credit" => "Credit",
            "debit" => "Debit",
            "uuid" => "Code",
        ],
        "action" => [
            "title" => "Wallet Transactions",
            "current_balance" => "Current Balance",
            "credit" => "Credit",
            "debit" => "Debit",
            "type" => "Type",
            "amount" => "Amount",
        ],
        "filters" => [
            "accounts" => "Filter by Accounts",
        ],
        "notification" => [
            "title" => "Operation Successful",
            "message" => " Wallet balance updated successfully.",
        ],

    ],

    "expenses" => [
        "title" => "Expenses",
        "single" => "Expense",
        "export" => "Export Expenses",
        "columns" => [
            "created_at" => "Date",
            "category" => "Category",
            "amount" => "Amount",
            "description" => "Description",
            "wallet" => "Wallet",
            "user" => "User",
            "confirmed" => "Confirmed",
            "uuid" => "Code",
            "today" => "Today",
            "this_month" => "This Month",
            "specific_date" => "Specific Date",
            'total' => "Total",
        ],
        "filters" => [
            "category" => "Filter by Category",
            "wallet" => "Filter by Wallet",
            "date_range" => "Filter by Date Range",
        ],
        "actions" => [
            "create" => "Add New Expense",
            "edit" => "Edit Expense",
            "delete" => "Delete Expense",
        ],
        "form" => [
            "category" => "Category",
            "amount" => "Amount",
            "description" => "Description",
            "wallet" => "Wallet",
            "date" => "Date",
        ],
        "widgets" => [
            "expenses_overview" => [
                "title" => "Expenses Overview",
                "description" => "View total expenses for today, this month, or a specific date.",
                "today" => "Today's Total Expenses",
                "this_month" => "This Month's Total Expenses",
                "this_week" => "This Week's Total Expenses",
                "specific_date" => "Total Expenses for Specific Date",
            ],
            "expenses_title" => [
                "today" => "Daily Expenses",
                "this_month" => "Monthly Expenses",
                "this_week" => "Weekly Expenses",
            ],
        ],
    ],


    "balance" => [
        "title" => "Balances",
        "single" => "Balance",
        "export" => "Export Expenses",
        "columns" => [
            "created_at" => "Date",
            "category" => "Category",
            "amount" => "Amount",
            "description" => "Description",
            "wallet" => "Wallet",
            "user" => "User",
            "confirmed" => "Confirmed",
            "uuid" => "Code",
            "today" => "Today",
            "this_month" => "This Month",
            "specific_date" => "Specific Date",
            'total' => "Total",
            'month' => "Month",
        ],
        "filters" => [
            "category" => "Filter by Category",
            "wallet" => "Filter by Wallet",
            "date_range" => "Filter by Date Range",
        ],
      
        "form" => [
            "category" => "Category",
            "amount" => "Amount",
            "description" => "Description",
            "wallet" => "Wallet",
            "date" => "Date",
        ],
        "widgets" => [
            "balance_overview" => [
                "title" => "Balance Overview",
                "description" => "View total balance for this month, or a specific Month.",

                "this_month" => "This Month's Total Balance",

                "specific_month" => "Total Expenses for Specific Month",
            ],
            "expenses_title" => [
                "this_month" => "Monthly Balance",
            ],
        ],
    ],


     "salary" => [
        "title" => "Salaries",
        "single" => "Salary",
        "export" => "Export Salaries",
        "calculate_salary" => "Calculate Salaries",
        "month_helper" => "Select the month for which you want to calculate salaries.",
        "month_placeholder" => "Select Month",
        "columns" => [
            "created_at" => "Date",
            "user" => "Employee",
            "amount" => "Amount",
            "type" => "Salary Type",
            "salary_date" => "Salary Date",
            "month" => "Month",
            "is_paid" => "Paid",
            "payment_method" => "Payment Method",
            "transaction_id" => "Transaction ID",
            "notes" => "Notes",
            "center_commission_value" => "Center Commission Value",
            "center_commission_percentage" => "Center Commission Percentage",
            "uuid" => "Code",
            "today" => "Today",
            "this_month" => "This Month",
            "specific_date" => "Specific Date",
            "total" => "Total",
            "center_commession_value" => "Center Commission Value",
            "center_commession_percentage" => "Center Commission Percentage",
        ],
        "filters" => [
            "user" => "Filter by Employee",
            "type" => "Filter by Salary Type",
            "month" => "Filter by Month",
            "date_range" => "Filter by Date Range",
            "is_paid" => "Filter by Payment Status",
        ],
        "actions" => [
            "create" => "Add New Salary",
            "edit" => "Edit Salary",
            "delete" => "Delete Salary",
            "mark_as_paid" => "Mark as Paid",
        ],
        "form" => [
            "user" => "Employee",
            "amount" => "Amount",
            "type" => "Salary Type",
            "salary_date" => "Salary Date",
            "month" => "Month",
            "is_paid" => "Paid",
            "payment_method" => "Payment Method",
            "transaction_id" => "Transaction ID",
            "notes" => "Notes",
            "center_commission_value" => "Center Commission Value",
            "center_commission_percentage" => "Center Commission Percentage",
        ],
        "widgets" => [
            "salary_overview" => [
                "title" => "Salary Overview",
                "description" => "Display total salaries for today, this month, or a specific month.",
                "this_month" => "Total Salaries This Month",
                "specific_month" => "Total Salaries for Selected Month",
                "today" => "Total Salaries Today",
                "commission" => "Total Center Commission This Month",
                "center_commission" => "Total Center Commission for Selected Month",
            ],
            "salary_title" => [
                "this_month" => "Monthly Salaries",
                "commission" => "Monthly Center Commission",

            ],
        ],
        "notifications" => [
            "paid_success" => [
                "title" => "Paid Successfully",
                "message" => "The salary status has been updated to paid successfully.",
            ],
            "created_success" => [
                "title" => "Created Successfully",
                "message" => "New salary has been added successfully.",
            ],
            "updated_success" => [
                "title" => "Updated Successfully",
                "message" => "Salary details have been updated successfully.",
            ],
            "deleted_success" => [
                "title" => "Deleted Successfully",
                "message" => "Salary has been deleted successfully.",
            ],
        ],
    ],

     "incoming" => [
        "title" => "Incomes",
        "single" => "Income",
        "export" => "Export Incomes",
        "columns" => [
            "created_at" => "Date",
            "category" => "Category",
            "amount" => "Amount",
            "description" => "Description",
            "wallet" => "Wallet",
            "user" => "User",
            "confirmed" => "Confirmed",
            "uuid" => "Code",
            "today" => "Today",
            "this_month" => "This Month",
            "specific_date" => "Specific Date",
            "total" => "Total",
            "source" => "Source",
        ],
        "filters" => [
            "category" => "Filter by Category",
            "wallet" => "Filter by Wallet",
            "date_range" => "Filter by Date Range",
        ],
        "actions" => [
            "create" => "Add New Income",
            "edit" => "Edit Income",
            "delete" => "Delete Income",
        ],
        "form" => [
            "category" => "Category",
            "amount" => "Amount",
            "description" => "Description",
            "wallet" => "Wallet",
            "date" => "Date",
            "source" => "Source",
        ],
        "widgets" => [
            "incoming_overview" => [
                "title" => "Income Overview",
                "description" => "View total incomes today, this month, or for a specific date.",
                "today" => "Total Income Today",
                "this_month" => "Total Income This Month",
                "this_week" => "Total Income This Week",
                "specific_date" => "Total Income for Specific Date",
            ],
            "incoming_title" => [
                "today" => "Daily Incomes",
                "this_month" => "Monthly Incomes",
                "this_week" => "Weekly Incomes",
            ],
        ],
        "notifications" => [
            "created_success" => [
                "title" => "Added Successfully",
                "message" => "The new income has been added successfully.",
            ],
            "updated_success" => [
                "title" => "Updated Successfully",
                "message" => "The income has been updated successfully.",
            ],
            "deleted_success" => [
                "title" => "Deleted Successfully",
                "message" => "The income has been deleted successfully.",
            ],
        ],
    ],
];
