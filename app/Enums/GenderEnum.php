<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum GenderEnum: string implements HasLabel
{
    case MALE = 'MALE';
    case FEMALE = 'FEMALE';

    public function getLabel(): ?string
    {
        return __('filament-panels::pages/user.' . $this->name);
    }
}
