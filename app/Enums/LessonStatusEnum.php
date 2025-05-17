<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum LessonStatusEnum: string implements HasLabel
{

    case SCHEDULED = 'SCHEDULED';
    case COMPLETED = 'COMPLETED';
    case CANCELLED = 'CANCELLED';
    case IN_PROGRESS = 'IN_PROGRESS';
    public function getLabel(): ?string
    {
        return __('filament-panels::pages/lesson.' . $this->name);
    }
}
