<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubjectResource\Pages;
use App\Models\Subject;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SubjectResource extends Resource
{
    protected static ?string $model = Subject::class;
    protected static ?int $navigationSort = 2;
    public static function getNavigationGroup(): ?string

    {
        return  __('filament-panels::pages/dashboard.settings');
    }
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    public static function getModelLabel(): string
    {
        return  __('filament-panels::pages/dashboard.subject');
    }
    public static function getPluralModelLabel(): string
    {
        return  __('filament-panels::pages/dashboard.subjects');
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Tabs::make("Translation")
                    ->tabs([
                        Tabs\Tab::make('Englis')
                            ->schema([
                                TextInput::make('name.en')
                                    ->label('Name in English')
                                    ->required(),
                                TextInput::make('description.en')
                                    ->label('Description (EN)'),
                            ]),
                        Tabs\Tab::make('Arabic')
                            ->label('الاسم بالعربي')
                            ->schema([
                                TextInput::make('name.ar')
                                    ->label('الإسم')
                                    ->required(),

                                TextInput::make('description.ar')
                                    ->label('الوصف'),
                            ]),

                    ]),
                Hidden::make('center_id')
                    ->default(fn() => auth()->user()->center->id)
                    ->required()

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('filament-panels::pages/general.name'))
                    ->searchable()
                    
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                    ->label(__('filament-panels::pages/general.description'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label(__('filament-panels::pages/general.status'))
                    ->sortable()
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
            'index' => Pages\ListSubjects::route('/'),
            'create' => Pages\CreateSubject::route('/create'),
            'edit' => Pages\EditSubject::route('/{record}/edit'),
        ];
    }
}
