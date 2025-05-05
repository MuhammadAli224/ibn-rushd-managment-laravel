<?php

namespace App\Filament\Sections;

use Parfaitementweb\FilamentCountryField\Forms\Components\Country;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use App\Enums\GenderEnum;

class UserInfoSection
{
    public static function make(array $additionalFields = [], string $prefix = 'user.'): Section
    {
        return Section::make(__('filament-panels::pages/general.user_info'))
            ->columns(3)
            ->schema([
                ...$additionalFields,
                TextInput::make("{$prefix}name")
                    ->label(__('filament-panels::pages/general.name'))
                    ->required(),

                TextInput::make("{$prefix}email")
                    ->label(__('filament-panels::pages/general.email'))
                    ->email()
                    ->unique(table: 'users', column: 'email', ignoreRecord: true)
                    ->required(),

                TextInput::make("{$prefix}phone")
                    ->label(__('filament-panels::pages/general.phone'))
                    ->tel()
                    ->unique(table: 'users', column: 'phone', ignoreRecord: true)
                    ->required(),

                TextInput::make("{$prefix}password")
                    ->label(__('filament-panels::pages/general.password'))
                    ->minLength(5)
                    ->password()
                    ->revealable()
                    ->required(fn(string $operation): bool => $operation === 'create'),

                TextInput::make("{$prefix}national_id")
                    ->numeric()
                    ->label(__('filament-panels::pages/general.national_id'))
                    ->unique(table: 'users', column: 'national_id', ignoreRecord: true)
                    ->required(),

                Select::make("{$prefix}gender")
                    ->label(__('filament-panels::pages/general.gender'))
                    ->options(GenderEnum::class)
                    ->required(),

                Country::make("{$prefix}country")
                    ->label(__('filament-panels::pages/general.country'))
                    ->exclude(['IL'])
                    ->default('QA')
                    ->searchable()
                    ->required(),

                FileUpload::make("{$prefix}image")
                    ->label(__('filament-panels::pages/general.image'))
                    ->disk('public')
                    ->directory('images/users')
                    ->image()
                    ->visibility('public')
                    ->columnSpan(2)
                    ->imageEditor(),

                    
                Hidden::make("{$prefix}center_id")
                    ->default(\auth()->user()->center->id)
            ]);
    }
}
