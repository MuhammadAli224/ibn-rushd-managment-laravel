<?php

namespace App\Filament\Resources;

use App\Filament\Components\CreatorUpdator;
use App\Filament\Resources\ExpenseResource\Pages;
use App\Filament\Resources\ExpenseResource\RelationManagers;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Tables\Actions\Action;

use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Enums\FiltersLayout;
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


    protected static ?string $navigationIcon = 'heroicon-o-calculator';

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
        ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('expenseCategory.name')
                    ->label(__('filament-panels::pages/wallet.expenses.columns.category'))

                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('amount')
                    ->label(__('filament-panels::pages/wallet.expenses.columns.amount'))
                    ->badge()
                    ->sortable()
                    ->summarize(
                        Tables\Columns\Summarizers\Sum::make()
                            ->label(__('filament-panels::pages/wallet.expenses.columns.total'))
                            ->money('QAR')
                    ),
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
                    // ->default()
                    ->label(__('filament-panels::pages/wallet.expenses.columns.today'))
                    ->query(fn(Builder $query) => $query->today()),

                Tables\Filters\Filter::make('this_month')
                    ->label(__('filament-panels::pages/wallet.expenses.columns.this_month'))
                    ->query(fn(Builder $query) => $query->thisMonth()),

                Tables\Filters\Filter::make('date')
                    ->label(__('filament-panels::pages/wallet.expenses.columns.specific_date'))
                    ->form([
                        Forms\Components\DatePicker::make('date')
                            ->label(__('filament-panels::pages/wallet.expenses.columns.specific_date')),
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query
                            ->when(
                                $data['date'],
                                fn(Builder $query, $date) => $query->whereDate('date', $date)
                            );
                    }),

                Tables\Filters\SelectFilter::make('expense_category_id')
                    ->label(__('filament-panels::pages/wallet.expenses.columns.category'))
                    ->options(fn(): array => ExpenseCategory::query()->pluck('name', 'id')->toArray())
                    ->query(function (Builder $query, array $data) {
                        return $query
                            ->when(
                                $data['value'] ?? null,
                                fn($query, $value) => $query->where('expense_category_id', $value)
                            );
                    }),
            ],)


            ->actions([
                Tables\Actions\EditAction::make(),
            ])

            ->filtersTriggerAction(
                fn(Action $action) => $action
                    ->button()
                    ->label('Filter'),
            );
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
