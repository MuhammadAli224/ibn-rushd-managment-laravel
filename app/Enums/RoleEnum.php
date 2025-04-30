<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum RoleEnum: string implements HasLabel
{
    case ADMIN = 'admin';
    case TEACHER = 'teacher';
    case DRIVER = 'driver';
    case ACCOUNTING = 'ACCOUNTING';
    case DISPATCHER = 'DISPATCHER';

    case STUDENT = 'student';
    case MANAGMENT = 'management';


    public function getLabel(): ?string
    {
        return $this->name;


        // return match ($this) {
        //     self::Draft => 'Draft',
        //     self::Reviewing => 'Reviewing',
        //     self::Published => 'Published',
        //     self::Rejected => 'Rejected',
        // };
    }
}
