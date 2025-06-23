<?php


return [
    'failed' => 'Validation failed. Please check the form.',
    'name_string' => 'The name must be a string.',
    'email_valid' => 'The email must be a valid email address.',
    'email_unique' => 'This email is already taken.',
    'phone_unique' => 'This phone number is already in use.',
    'password_min' => 'The password must be at least 6 characters.',
    'password_confirmed' => 'The password confirmation does not match.',
    'tax_number_unique' => 'This tax number is already in use.',
    'comerical_number_unique' => 'This commercial number is already in use.',
    'name_required' => 'The name is required.',
    'email_required' => 'The email address is required.',
    'phone_required' => 'The phone number is required.',
    'password_required' => 'The password is required.',
    'user_id_required' => 'The user identification is required.',
    'user_id_exists' => 'The user does not exist.',

    'tax_number_required' => 'The tax number is required.',
    'tax_number_string' => 'The tax number must be a string.',

    'comerical_number_required' => 'The commercial number is required.',
    'comerical_number_string' => 'The commercial number must be a string.',

    'image_image' => 'The file must be an image.',
    'image_mimes' => 'The image must be a file of type: jpg, jpeg, png.',
    'image_max' => 'The image may not be greater than 2MB.',

    'branch_id.required' => 'The Branch is required.',
    'branch_id.exists' => 'The Branch does not exist.',



    'required' => 'The :attribute field is required.',
    'email' => 'The :attribute must be a valid email address.',
    'unique' => 'The :attribute has already been taken.',
    'confirmed' => 'The :attribute confirmation does not match.',
    'string' => 'The :attribute must be a string.',
    'max' => [
        'string' => 'The :attribute may not be greater than :max characters.',
    ],
    'min' => [
        'string' => 'The :attribute must be at least :min characters.',
    ],

    'attributes' => [
        'name' => 'name',
        'email' => 'email address',
        'phone' => 'phone number',
        'password' => 'password',
        'tax_number' => 'tax number',
        'comerical_number' => 'comerical number',
        'name_ar' => 'Arabic name',
        'name_en' => 'English name',
    ],


    'product' => [
        'name_required' => 'The product name is required.',
        'name_string' => 'The product name must be a string.',
        'name_max' => 'The product name is too long.',

        'price_required' => 'The price is required.',
        'price_numeric' => 'The price must be a number.',

        'cost_required' => 'The cost is required.',
        'cost_numeric' => 'The cost must be a number.',

        'unit_required' => 'The unit is required.',
        'unit_string' => 'The unit must be a string.',
        'unit_max' => 'The unit is too long.',

        'image_image' => 'The uploaded file must be an image.',
        'image_mimes' => 'The image must be a file of type: jpg, jpeg, png.',
        'image_max' => 'The image size is too large.',

        'product_no_required' => 'The product number is required.',
        'product_no_integer' => 'The product number must be an integer.',
        'product_no_unique' => 'The product number has already been taken.',

        'category_id_required' => 'The category is required.',
        'category_id_exists' => 'The selected category does not exist.',

        'payment_type_required' => 'The payment type is required.',
        'payment_type_in' => 'The selected payment type is invalid.',

        'branches_required' => 'At least one branch is required.',
        'branches_array' => 'The branches field must be an array.',

        'branch_id_required' => 'The branch ID is required.',
        'branch_id_exists' => 'The selected branch does not exist.',

        'quantity_required' => 'The quantity is required.',
        'quantity_integer' => 'The quantity must be an integer.',

        'is_active_boolean' => 'The active field must be true or false.',
        'is_most_popular_boolean' => 'The most popular field must be true or false.',

        'status_in' => 'The status must be either "active" or "inactive".',
    ],

    'category' => [
        'name_required' => 'Category name is required.',
        'name_array' => 'The name field must be an array.',
        'name_ar_required' => 'The Arabic name is required.',
        'name_en_required' => 'The English name is required.',
        'branch_id_required' => 'Branch is required.',
        'branch_id_exists' => 'The selected branch is invalid.',
    ],

    'login_required' => 'The login field is required.',


];
