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
        ]
    ],

    "expenses" => [
        "title" => "Expenses",
        "single" => "Expense",
        "columns" => [
            "created_at" => "Date",
            "category" => "Category",
            "amount" => "Amount",
            "description" => "Description",
            "wallet" => "Wallet",
            "user" => "User",
            "confirmed" => "Confirmed",
            "uuid" => "Code",
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
    ],
];
