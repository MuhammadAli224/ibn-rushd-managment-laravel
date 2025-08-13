<?php

namespace App\Filament\Resources;

use App\Filament\Components\CreatorUpdator;
use App\Filament\Components\UserTable;
use App\Filament\Resources\GuardianResource\Pages;
use App\Filament\Resources\GuardianResource\RelationManagers;
use App\Filament\Resources\GuardianResource\RelationManagers\StudentsRelationManager;
use App\Filament\Sections\UserInfoSection;
use App\Models\Guardian;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GuardianResource extends Resource
{
    protected static ?string $model = Guardian::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?int $navigationSort = 3;
     public static function getNavigationBadge(): ?string
    {
        
        return static::getModel()::count();
    }
    public static function getModelLabel(): string
    {
        return  __('filament-panels::pages/dashboard.guardian');
    }
    public static function getPluralModelLabel(): string
    {
        return  __('filament-panels::pages/dashboard.guardians');
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
                Section::make(__('filament-panels::pages/guardian.guardian_info'))
                    ->columns(2)
                    ->schema([

                        TextInput::make('whatsapp')
                            ->label(__('filament-panels::pages/guardian.whatsapp'))
                            ->numeric()
                            ->required(),

                        TextInput::make('occupation')
                            ->label(__('filament-panels::pages/guardian.occupation'))
                            ->required(),


                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ...UserTable::columns(),

                TextColumn::make('occupation')
                    ->label(__('filament-panels::pages/guardian.occupation'))
                    ->searchable(),

                TextColumn::make('whatsapp')
                    ->label(__('filament-panels::pages/guardian.whatsapp'))
                    ->sortable()
                    ->searchable(),
                ...CreatorUpdator::columns(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            StudentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGuardians::route('/'),
            'create' => Pages\CreateGuardian::route('/create'),
            'edit' => Pages\EditGuardian::route('/{record}/edit'),
        ];
    }
}
