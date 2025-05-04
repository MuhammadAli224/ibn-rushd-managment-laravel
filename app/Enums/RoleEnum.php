<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum RoleEnum: string implements HasLabel
{
    case ADMIN = 'ADMIN';
    case MANAGMENT = 'MANAGMENT';
    case PARENT = 'PARENT';
    case TEACHER = 'TEACHER';
    case STUDENT = 'STUDENT';
    case DRIVER = 'DRIVER';
    case ACCOUNTING = 'ACCOUNTING';
    case DISPATCHER = 'DISPATCHER';




    public function getLabel(): ?string
    {
        return __('filament-panels::pages/roles.' . $this->name);
    }
}
