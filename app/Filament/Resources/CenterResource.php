<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CenterResource\Pages;
use App\Filament\Resources\CenterResource\RelationManagers;
use App\Models\Center;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CenterResource extends Resource
{
    protected static ?string $model = Center::class;

    protected static ?int $navigationSort = 2;


    public static function getNavigationGroup(): ?string

    {
        return  __('filament-panels::pages/dashboard.settings');
    }
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    public static function getModelLabel(): string
    {
        return  __('filament-panels::pages/dashboard.center');
    }
    public static function getPluralModelLabel(): string
    {
        return  __('filament-panels::pages/dashboard.center_info');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label(__('filament-panels::pages/center.name'))
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->label(__('filament-panels::pages/center.email'))
                            ->email()
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('phone')
                            ->label(__('filament-panels::pages/center.phone'))
                            ->tel()

                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('address')
                            ->label(__('filament-panels::pages/center.address'))
                            ->required()
                            ->maxLength(255),
                        // Forms\Components\FileUpload::make('image')

                        //     ->image(),
                        Forms\Components\Repeater::make('commission_ranges')
                            ->label(__('filament-panels::pages/center.commission_ranges'))
                            ->schema([
                                Forms\Components\TextInput::make('min')
                                   ->label(__('filament-panels::pages/center.min_value'))
                                    ->numeric()
                                    ->required(),

                                Forms\Components\TextInput::make('max')
                                    ->label(__('filament-panels::pages/center.max_value'))
                                    ->numeric()
                                    ->nullable(),

                                Forms\Components\TextInput::make('percentage')
                                    ->label(__('filament-panels::pages/center.percentage'))
                                    ->numeric()
                                    ->suffix('%')
                                    ->required(),
                            ])
                            // ->default([
                            //     ['min' => 0,     'max' => 19999, 'percentage' => 40],
                            //     ['min' => 20000, 'max' => null,  'percentage' => 50],
                            // ])
                            ->columns(2)
                            // ->columnSpanFull()


                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('filament-panels::pages/center.name')),
                Tables\Columns\TextColumn::make('email')
                    ->label(__('filament-panels::pages/center.email')),
                Tables\Columns\TextColumn::make('phone')
                    ->label(__('filament-panels::pages/center.phone')),
                Tables\Columns\TextColumn::make('address')
                    ->label(__('filament-panels::pages/center.address')),
                Tables\Columns\ImageColumn::make('image'),
                Tables\Columns\TextColumn::make('commission_ranges')
                    ->label(__('filament-panels::pages/center.commission_ranges'))

            ])
            ->filters([
                //
            ])
            ->actions([])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCenters::route('/'),
            'edit' => Pages\EditCenter::route('/{record}/edit'),
        ];
    }
}
