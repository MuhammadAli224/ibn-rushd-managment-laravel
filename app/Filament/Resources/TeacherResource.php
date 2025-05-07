<?php

namespace App\Filament\Resources;

use App\Enums\QualificationEnum;
use App\Filament\Components\CreatorUpdator;
use App\Filament\Components\UserTable;
use App\Filament\Resources\TeacherResource\Pages;
use App\Filament\Sections\UserInfoSection;
use App\Models\Teacher;
use Dom\Text;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class TeacherResource extends Resource
{
    protected static ?string $model = Teacher::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?int $navigationSort = 1;

    public static function getModelLabel(): string
    {
        return  __('filament-panels::pages/dashboard.teacher');
    }
    public static function getPluralModelLabel(): string
    {
        return  __('filament-panels::pages/dashboard.teachers');
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

                Section::make(__('filament-panels::pages/teachers.teacher_info'))
                    ->columns(3)
                    ->schema([
                        DatePicker::make('date_of_birth')
                            ->label(__('filament-panels::pages/teachers.date_of_birth'))
                            ->native(false)
                            ->displayFormat('d/m/Y')
                            ->closeOnDateSelection()
                            ->minDate(now()->subYears(60))
                            ->maxDate(now()->subYears(18))
                            ->weekStartsOnSunday()
                            ->suffixIcon('heroicon-o-calendar-date-range')
                            ->locale('ar'),


                        Select::make('qualification')
                            ->label(__('filament-panels::pages/teachers.qualification'))
                            ->options(QualificationEnum::class)
                            ->required(),

                        TextInput::make('specialization')
                            ->label(__('filament-panels::pages/teachers.specialization'))
                            ->required(),

                        TextInput::make('experience')
                            ->label(__('filament-panels::pages/teachers.experience'))
                            ->numeric()
                            ->required(),


                        TextInput::make('commission')
                            ->label(__('filament-panels::pages/teachers.commission'))
                            ->numeric()

                            ->suffix('%')
                            ->required(),

                        Select::make('subjects')
                            ->label(__('filament-panels::pages/teachers.subjects'))
                            ->relationship('subjects', 'name')
                            ->multiple()
                            ->preload()
                            ->searchable()
                            ->required(),




                    ])



            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ...UserTable::columns(),

                TextColumn::make('specialization')
                    ->label(__('filament-panels::pages/teachers.specialization'))
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->badge()
                    ->searchable(),

                TextColumn::make('subjects.name')
                    ->label(__('filament-panels::pages/teachers.subjects'))
                    ->sortable()
                    ->badge()
                    ->searchable(),
                TextColumn::make('qualification')
                    ->label(__('filament-panels::pages/teachers.qualification'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('experience')
                    ->label(__('filament-panels::pages/teachers.experience'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
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
            'index' => Pages\ListTeachers::route('/'),
            'create' => Pages\CreateTeacher::route('/create'),
            'edit' => Pages\EditTeacher::route('/{record}/edit'),
        ];
    }
}
