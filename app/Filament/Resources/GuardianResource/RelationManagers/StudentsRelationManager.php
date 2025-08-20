<?php

namespace App\Filament\Resources\GuardianResource\RelationManagers;

use App\Enums\RoleEnum;
use App\Filament\Components\CreatorUpdator;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StudentsRelationManager extends RelationManager
{
    protected static string $relationship = 'students';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label(__('filament-panels::pages/students.name'))
                    ->required()
                    ->maxLength(255),

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
                    ->minLength(10)
                    ->afterStateHydrated(function (Forms\Components\TextInput $component, $state) {
                        if (blank($state)) {
                            $component->state($this->ownerRecord->user->phone ?? '');
                        }
                    }),

                Forms\Components\TextInput::make('address')
                    ->label(__('filament-panels::pages/students.address'))
                    ->required(),
                Select::make('subjects')
                    ->label(__('filament-panels::pages/teachers.subjects'))
                    ->relationship('subjects', 'name')
                    ->multiple()
                    ->preload()
                    ->searchable()
                    ->disabled(
                        fn($get) => !auth()->user()->hasRole(RoleEnum::ADMIN->value)
                    )
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('filament-panels::pages/students.name'))
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('class')
                    ->label(__('filament-panels::pages/students.class'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('subjects.name')
                    ->label(__('filament-panels::pages/teachers.subjects'))
                    ->sortable()
                    ->badge()
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
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
