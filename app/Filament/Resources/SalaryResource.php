<?php

namespace App\Filament\Resources;

use App\Enums\RoleEnum;
use App\Filament\Resources\SalaryResource\Pages;
use App\Filament\Resources\SalaryResource\RelationManagers;
use App\Models\Salary;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Spatie\Permission\Contracts\Role;

class SalaryResource extends Resource
{
    protected static ?string $model = Salary::class;


    protected static ?string $navigationIcon = 'heroicon-o-wallet';

    protected static ?int $navigationSort = 1;

    public static function getNavigationGroup(): ?string
    {
        return __('filament-panels::pages/wallet.groupName');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament-panels::pages/wallet.salary.title');
    }

    public static function getPluralLabel(): ?string
    {
        return __('filament-panels::pages/wallet.salary.title');
    }

    public static function getLabel(): ?string
    {
        return __('filament-panels::pages/wallet.salary.single');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->columns(3)
                    ->schema([

                        Forms\Components\TextInput::make('user_id')
                            ->label(__('filament-panels::pages/wallet.salary.columns.user'))
                            ->disabledOn('edit')
                            ->required()
                            ->numeric(),
                        Forms\Components\TextInput::make('month')
                            ->disabledOn('edit')
                            ->label(__('filament-panels::pages/wallet.salary.columns.month'))
                            ->maxLength(7),

                        Forms\Components\TextInput::make('amount')
                            ->label(__('filament-panels::pages/wallet.salary.columns.amount'))
                            ->required()
                            ->numeric()
                            ->default(0.00),





                        Forms\Components\TextInput::make('payment_method')
                            ->label(__('filament-panels::pages/wallet.salary.columns.payment_method'))
                            ->maxLength(255),





                        Forms\Components\TextInput::make('transaction_id')
                            ->label(__('filament-panels::pages/wallet.salary.columns.transaction_id'))
                            ->maxLength(255),

                        Forms\Components\Textarea::make('notes')
                            ->label(__('filament-panels::pages/wallet.salary.columns.notes'))

                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('center_commession_value')
                            ->label(__('filament-panels::pages/wallet.salary.columns.center_commession_value'))
                            ->numeric()
                            ->suffix('QAR')
                            ->maxLength(255),

                        Forms\Components\TextInput::make('center_commession_percentage')
                            ->label(__('filament-panels::pages/wallet.salary.columns.center_commession_percentage'))
                            ->numeric()
                            ->suffix('%')
                            ->maxLength(255),

                        Forms\Components\Toggle::make('is_paid')
                            ->label(__('filament-panels::pages/wallet.salary.columns.is_paid'))
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label(__('filament-panels::pages/wallet.salary.columns.user'))
                    ->searchable(),

                Tables\Columns\TextColumn::make('amount')
                    ->label(__('filament-panels::pages/wallet.salary.columns.amount'))
                    ->badge()
                    ->sortable(),


                Tables\Columns\TextColumn::make('salary_date')
                    ->label(__('filament-panels::pages/wallet.salary.columns.salary_date'))
                    ->date('Y-m-d')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('month')
                    ->label(__('filament-panels::pages/wallet.salary.columns.month'))
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_paid')
                    ->label(__('filament-panels::pages/wallet.salary.columns.is_paid'))
                    ->boolean(),

                Tables\Columns\TextColumn::make('payment_method')
                    ->label(__('filament-panels::pages/wallet.salary.columns.payment_method'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('transaction_id')
                    ->label(__('filament-panels::pages/wallet.salary.columns.transaction_id'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('center_commession_value')
                    ->badge()
                    ->color('danger')
                    ->label(__('filament-panels::pages/wallet.salary.columns.center_commession_value'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('center_commession_percentage')
                    ->label(__('filament-panels::pages/wallet.salary.columns.center_commession_percentage'))
                    ->searchable(),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->visible(
                        fn($record) =>
                        !$record->is_paid  &&
                            (auth()->user()->hasRole(RoleEnum::ADMIN->value) ||
                                auth()->user()->hasRole(RoleEnum::ACCOUNTANT->value))
                    ),
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
            'index' => Pages\ListSalaries::route('/'),
            'create' => Pages\CreateSalary::route('/create'),
            'edit' => Pages\EditSalary::route('/{record}/edit'),
        ];
    }
}
