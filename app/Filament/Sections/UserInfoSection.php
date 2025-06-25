<?php

namespace App\Filament\Sections;

use Parfaitementweb\FilamentCountryField\Forms\Components\Country;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use App\Enums\GenderEnum;
use Filament\Forms\Components\Grid;
use Illuminate\Support\Facades\Hash;


class UserInfoSection
{
    public static function make(array $additionalFields = [], string $prefix = 'user.'): Section
    {
        return Section::make(__('filament-panels::pages/general.user_info'))

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

                // TextInput::make("{$prefix}password")
                //     ->label(__('filament-panels::pages/general.password'))
                //     ->minLength(8)
                //     ->password()
                //     ->revealable()
                //     ->required(fn(string $operation): bool => $operation === 'create'),
                TextInput::make("{$prefix}password")
                    ->label(__('filament-panels::pages/general.password'))
                    ->minLength(8)
                    ->password()
                    ->revealable()
                    ->required(fn(string $operation): bool => $operation === 'create')
                    ->dehydrated(fn($state) => filled($state))
                    ->dehydrateStateUsing(fn($state) => Hash::make($state)),

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
                    ->columnSpanFull()

                    ->imageEditor(),


                Hidden::make("{$prefix}center_id")
                    ->default(\auth()->user()->center->id)
            ])
            ->columns([
                'sm' => 1,
                'md' => 2,
                'lg' => 2,
                'xl' => 3,
                '2xl' => 3,
            ])
            ->columnSpan([
                'sm' => 1,
                'md' => 2,
                'lg' => 2,
                'xl' => 3,
                '2xl' => 3,
            ]);
    }
}
