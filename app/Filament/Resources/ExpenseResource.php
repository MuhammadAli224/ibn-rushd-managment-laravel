<?php

namespace App\Filament\Resources;

use App\Filament\Components\CreatorUpdator;
use App\Filament\Resources\ExpenseResource\Pages;
use App\Filament\Resources\ExpenseResource\RelationManagers;
use App\Models\Expense;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ExpenseResource extends Resource
{
    protected static ?string $model = Expense::class;

    protected static ?int $navigationSort = 1;


    public static function getNavigationGroup(): ?string
    {
        return __('filament-panels::pages/wallet.groupName');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament-panels::pages/wallet.expenses.title');
    }

    public static function getPluralLabel(): ?string
    {
        return __('filament-panels::pages/wallet.expenses.title');
    }

    public static function getLabel(): ?string
    {
        return __('filament-panels::pages/wallet.expenses.title');
    }


    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Hidden::make("center_id")
                    ->default(\auth()->user()->center->id),

                Section::make()
                    ->columns(3)
                    ->schema([

                        Select::make('expense_category_id')
                            ->label(__('filament-panels::pages/wallet.expenses.columns.category'))
                            ->relationship('expenseCategory', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),

                        TextInput::make('amount')
                            ->label(__('filament-panels::pages/wallet.expenses.columns.amount'))
                            ->numeric()
                            ->required()
                            ->minValue(0.01),
                        DatePicker::make('date')
                            ->label(__('filament-panels::pages/wallet.expenses.columns.created_at'))
                            ->default(now())
                            ->required(),
                        Forms\Components\Textarea::make('description')
                            ->label(__('filament-panels::pages/wallet.expenses.columns.description'))
                            ->columnSpanFull(),


                    ])

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('expenseCategory.name')
                    ->label(__('filament-panels::pages/wallet.expenses.columns.category'))

                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('amount')
                    ->label(__('filament-panels::pages/wallet.expenses.columns.amount'))
                    // ->numeric()
                     ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date')
                    ->label(__('filament-panels::pages/wallet.expenses.columns.created_at'))

                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                    ->label(__('filament-panels::pages/wallet.expenses.columns.description'))

                    ->sortable(),
                ...CreatorUpdator::columns(),


            ])
            ->filters([
                Tables\Filters\Filter::make('today')
                    ->label(__('Today'))
                    ->query(fn(Builder $query) => $query->today()),

                Tables\Filters\Filter::make('this_month')
                    ->label(__('This Month'))
                    ->query(fn(Builder $query) => $query->thisMonth()),

                Tables\Filters\Filter::make('date')
                    ->label(__('Specific Date'))
                    ->form([
                        Forms\Components\DatePicker::make('date'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query
                            ->when(
                                $data['date'],
                                fn(Builder $query, $date) => $query->whereDate('date', $date)
                            );
                    }),
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
            'index' => Pages\ListExpenses::route('/'),
            'create' => Pages\CreateExpense::route('/create'),
            'edit' => Pages\EditExpense::route('/{record}/edit'),
        ];
    }
}
