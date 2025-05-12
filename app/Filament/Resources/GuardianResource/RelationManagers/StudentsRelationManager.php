<?php

namespace App\Filament\Resources\GuardianResource\RelationManagers;

use App\Filament\Components\CreatorUpdator;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
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

                Forms\Components\TextInput::make('class')
                    ->label(__('filament-panels::pages/students.class'))
                    ->required()
                    ->maxLength(255),

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
