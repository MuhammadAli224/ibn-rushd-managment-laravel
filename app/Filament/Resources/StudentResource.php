<?php

namespace App\Filament\Resources;

use App\Enums\RoleEnum;
use App\Filament\Components\CreatorUpdator;
use App\Filament\Resources\StudentResource\Pages;
use App\Filament\Resources\StudentResource\RelationManagers;
use App\Models\Student;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?int $navigationSort = 4;
     public static function getNavigationBadge(): ?string
    {
        
        return static::getModel()::count();
    }
    public static function getModelLabel(): string
    {
        return  __('filament-panels::pages/dashboard.student');
    }
    public static function getPluralModelLabel(): string
    {
        return  __('filament-panels::pages/dashboard.students');
    }
    public static function getNavigationGroup(): ?string

    {
        return  __('filament-panels::pages/dashboard.users');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->columns(2)
                    ->schema([
                        Select::make('guardian_id')
                            ->label(__('filament-panels::pages/students.guardian'))
                            ->options(
                                \App\Models\Guardian::whereHas(
                                    'user.roles',
                                    fn($q) =>
                                    $q->where('name', RoleEnum::PARENT->value)
                                )->with('user')->get()->pluck('user.name', 'id')
                            )
                            ->required()
                            ->searchable()
                            ->preload()
                            ->reactive()
                            ->afterStateUpdated(function ($state, $set) {
                                $guardian = \App\Models\Guardian::with('user')->find($state);
                                if ($guardian) {
                                    $set('phone', $guardian->user->phone ?? '');
                                    $set('address', $guardian->user->address ?? '');
                                }
                            }),

                        Forms\Components\TextInput::make('name')
                            ->label(__('filament-panels::pages/students.name'))
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('class')
                            ->label(__('filament-panels::pages/students.class'))
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('phone')
                            ->label(__('filament-panels::pages/students.phone'))
                            ->required()
                            ->tel()
                            ->maxLength(10)
                            ->minLength(10),

                        Forms\Components\TextInput::make('address')
                            ->label(__('filament-panels::pages/students.address'))
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                  Tables\Columns\TextColumn::make('name')
                    ->label(__('filament-panels::pages/students.name'))
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('class')
                    ->label(__('filament-panels::pages/students.class'))
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('phone')
                    ->label(__('filament-panels::pages/students.phone'))
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('address')
                    ->label(__('filament-panels::pages/students.address'))
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    }
}
