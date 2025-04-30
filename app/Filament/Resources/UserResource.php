<?php

namespace App\Filament\Resources;

use App\Enums\GenderEnum;
use App\Enums\RoleEnum;
use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    // use Translatable;
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    public static function getModelLabel(): string
    {
        return  __('filament-panels::pages/dashboard.users');
    }
    public static function getPluralModelLabel(): string
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
                        Select::make('role')
                            ->label(__('filament-panels::pages/user.role'))
                            ->options(RoleEnum::class)
                            ->required()
                            ->reactive(),

                        Select::make('gender')
                            ->label(__('filament-panels::pages/user.gender'))
                            ->options(GenderEnum::class)
                            ->required(),

                        TextInput::make('name')
                            ->label(__('filament-panels::pages/user.name'))
                            ->required()
                            ->minLength(3)
                            ->maxLength(255),

                        TextInput::make('email')
                            ->label(__('filament-panels::pages/user.email'))
                            ->email()
                            ->unique()
                            ->required(),

                        TextInput::make('phone')
                            ->label(__('filament-panels::pages/user.phone'))
                            ->tel()
                            ->unique()
                            ->required(),

                        TextInput::make('address')
                            ->label(__('filament-panels::pages/user.address')),

                        FileUpload::make('image')
                            ->label(__('filament-panels::pages/user.image'))
                            ->disk('public')
                            ->directory('users/images')
                            ->image()
                            ->visibility('public')
                            ->columnSpanFull()
                            ->imageEditor(),

                    ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('filament-panels::pages/user.name'))
                    ->sortable()
                    ->searchable(),

                TextColumn::make('email')
                    ->label(__('filament-panels::pages/user.email'))
                    ->sortable()
                    ->searchable(),

                TextColumn::make('phone')
                    ->label(__('filament-panels::pages/user.phone'))
                    ->sortable()
                    ->searchable(),

                TextColumn::make('roles.name')
                    ->label(__('filament-panels::pages/user.role'))
                    ->formatStateUsing(fn($state, $record) => __('filament-panels::pages/user.'.$state))
                    ->sortable()
                    ->searchable(),


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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
