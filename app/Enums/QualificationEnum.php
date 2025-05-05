<?php

namespace App\Enums;
use Filament\Support\Contracts\HasLabel;

enum QualificationEnum :string implements HasLabel
{
    case HighSchool = 'HighSchool';
    case Diploma = 'Diploma';
    case Bachelor = 'Bachelor';
    case Master = 'Master';
    case Doctorate = 'Doctorate';
    case Other = 'Other';


    public function getLabel(): ?string
    {
        return __('filament-panels::pages/general.' . $this->name);
    }
}
