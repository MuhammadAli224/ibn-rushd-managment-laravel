<?php

namespace App\Filament\Resources;

use App\Filament\Components\CreatorUpdator;
use App\Filament\Components\UserTable;
use App\Filament\Resources\DriverResource\Pages;
use App\Filament\Sections\UserInfoSection;
use App\Models\Driver;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DriverResource extends Resource
{
    protected static ?string $model = Driver::class;

    protected static ?string $navigationIcon = 'heroicon-o-identification';

    protected static ?int $navigationSort = 2;

    public static function getModelLabel(): string
    {
        return  __('filament-panels::pages/dashboard.driver');
    }
    public static function getPluralModelLabel(): string
    {
        return  __('filament-panels::pages/dashboard.drivers');
    }
    public static function getNavigationGroup(): ?string

    {
        return  __('filament-panels::pages/dashboard.users');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                UserInfoSection::make([], prefix: 'user.')
                    ->hiddenOn('edit'),


                Section::make(__('filament-panels::pages/drivers.driver_info'))
                    ->columns(3)
                    ->schema([

                        TextInput::make('license_number')
                            ->label(__('filament-panels::pages/drivers.license_number'))
                            ->numeric()
                            ->required(),

                        TextInput::make('vehicle_type')
                            ->label(__('filament-panels::pages/drivers.vehicle_type'))
                            ->required(),

                        TextInput::make('vehicle_number')
                            ->label(__('filament-panels::pages/drivers.vehicle_number'))
                            ->numeric()
                            ->required(),

                        FileUpload::make("attachment")
                            ->label(__('filament-panels::pages/general.attachment'))
                            ->disk('public')
                            ->directory('images/driver_attachments')
                            ->image()
                            ->visibility('public'),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                ...UserTable::columns(),

                TextColumn::make('license_number')
                    ->label(__('filament-panels::pages/drivers.license_number'))
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->searchable(),

                TextColumn::make('vehicle_number')
                    ->label(__('filament-panels::pages/drivers.vehicle_number'))
                    ->sortable()
                    ->badge()
                    ->searchable(),
                TextColumn::make('vehicle_type')
                    ->label(__('filament-panels::pages/drivers.vehicle_type'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),

                ImageColumn::make('attachment')
                    ->label(__('filament-panels::pages/general.attachment'))
                    
                    ->toggleable(isToggledHiddenByDefault: true),
                ...CreatorUpdator::columns(),








            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
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
            'index' => Pages\ListDrivers::route('/'),
            'create' => Pages\CreateDriver::route('/create'),
            'edit' => Pages\EditDriver::route('/{record}/edit'),
        ];
    }
}
