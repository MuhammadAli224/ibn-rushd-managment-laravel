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

                        // Forms\Components\TextInput::make('class')
                        //     ->label(__('filament-panels::pages/students.class'))
                        //     ->required()
                        //     ->maxLength(255),

                        Select::make('class')
                            ->label(__('filament-panels::pages/students.class'))
                            ->options([
                                'grade_1' => __('filament-panels::pages/students.classes.grade_1'),
                                'grade_2' => __('filament-panels::pages/students.classes.grade_2'),
                                'grade_3' => __('filament-panels::pages/students.classes.grade_3'),
                                'grade_4' => __('filament-panels::pages/students.classes.grade_4'),
                                'grade_5' => __('filament-panels::pages/students.classes.grade_5'),
                                'grade_6' => __('filament-panels::pages/students.classes.grade_6'),
                                'grade_7' => __('filament-panels::pages/students.classes.grade_7'),
                                'grade_8' => __('filament-panels::pages/students.classes.grade_8'),
                                'grade_9' => __('filament-panels::pages/students.classes.grade_9'),
                                'grade_10' => __('filament-panels::pages/students.classes.grade_10'),
                                'grade_11' => __('filament-panels::pages/students.classes.grade_11'),
                                'grade_12' => __('filament-panels::pages/students.classes.grade_12'),
                                'diploma' => __('filament-panels::pages/students.classes.diploma'),
                                'university' => __('filament-panels::pages/students.classes.university'),
                            ])
                            ->required()
                            ->searchable(),

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
                    ->formatStateUsing(fn($state) => __(
                        'filament-panels::pages/students.classes.' . $state
                    )),

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
