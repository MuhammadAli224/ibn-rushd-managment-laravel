<?php

namespace App\Enums;

enum PermissionEnum:string
{
    case MANAGE_USERS = 'manage users';
    case MANAGE_COURSES = 'manage courses';
    case VIEW_ORDERS = 'view orders';
}
