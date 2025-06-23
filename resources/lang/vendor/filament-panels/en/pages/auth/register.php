<?php

return [

    'title' => 'Register',

    'heading' => 'Sign up',

    'actions' => [

        'login' => [
            'before' => 'or',
            'label' => 'sign in to your account',
        ],

    ],

    'form' => [

        'email' => [
            'label' => 'Email address',
        ],
        'phone' => [
            'label' => 'Phone number',
        ],
        'is_active' => [
            'label' => "Status",
        ],
        "branch" => [
            'label' => "Branch",
        ],
        "client" => [
            'label' => "Client",
        ],

        'name' => [
            'label' => 'Name',
        ],

        'password' => [
            'label' => 'Password',
            'validation_attribute' => 'password',
        ],

        'password_confirmation' => [
            'label' => 'Confirm password',
        ],

        'actions' => [

            'register' => [
                'label' => 'Sign up',
            ],

        ],

    ],

    'notifications' => [

        'throttled' => [
            'title' => 'Too many registration attempts',
            'body' => 'Please try again in :seconds seconds.',
        ],

    ],

];
