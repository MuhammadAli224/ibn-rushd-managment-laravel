<?php

namespace App\Enums;

enum RoleEnum :string
{
    case ADMIN = 'admin';
    case TEACHER = 'teacher';
    case DRIVER = 'driver';
    case ACCOUNTING = 'ACCOUNTING';
    case DISPATCHER = 'DISPATCHER';
    
    case STUDENT = 'student';
    case MANAGMENT = 'management';
}
