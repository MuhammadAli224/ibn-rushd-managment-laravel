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
];
