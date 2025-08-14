<?php

namespace App\Filament\Resources;


use App\Enums\RoleEnum;
use App\Filament\Actions\WalletAction;
use App\Filament\Resources\UserResource\Pages;
use App\Filament\Sections\UserInfoSection;
use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';



    public static function getModelLabel(): string
    {
        return  __('filament-panels::pages/dashboard.user');
    }
    public static function getPluralModelLabel(): string
    {
        return  __('filament-panels::pages/dashboard.users');
    }


    public static function getNavigationGroup(): ?string

    {
        return  __('filament-panels::pages/dashboard.users');
    }
    public static function getNavigationBadge(): ?string
    {

        return static::getModel()::where(function ($q) {
            $q->where('is_super_admin', '!=', 1)
                ->orWhereNull('is_super_admin');
        })->count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                UserInfoSection::make(
                    [

                        Select::make('assign_role')
                            ->label(__('filament-panels::pages/user.role'))
                            ->required()
                            ->native(false)
                            ->options(function () {
                                $auth = auth()->user();
                                $allRoles = RoleEnum::cases();

                                if ($auth->hasRole(RoleEnum::ADMIN->value)) {



                                    return collect($allRoles)->mapWithKeys(fn($role) => [
                                        $role->value => $role->getLabel(),
                                    ]);
                                }
                            })
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set, ?User $record) {
                                if ($record) {
                                    $record->syncRoles([$state]);
                                }
                            })
                            ->visible(function (?User $record) {
                                $auth = auth()->user();

                                if ($auth->hasRole(RoleEnum::ADMIN->value)) {
                                    return true;
                                }


                                return false;
                            })

                            ->afterStateHydrated(function (callable $set, ?User $record) {
                                if ($record) {
                                    $roles = $record->roles->pluck('name')->toArray();
                                    $set('assign_role', $roles[0] ?? null);
                                }
                            }),

                    ],
                    '',
                ),

                //     ->columns(2)
                //     ->schema([
                //         Select::make('role')
                //             ->label(__('filament-panels::pages/user.role'))
                //             ->options(RoleEnum::class)
                //             ->required()
                //             ->reactive(),

                //         Select::make('gender')
                //             ->label(__('filament-panels::pages/user.gender'))
                //             ->options(GenderEnum::class)
                //             ->required(),

                //         TextInput::make('name')
                //             ->label(__('filament-panels::pages/user.name'))
                //             ->required()
                //             ->minLength(3)
                //             ->maxLength(255),

                //         TextInput::make('email')
                //             ->label(__('filament-panels::pages/user.email'))
                //             ->email()
                //             ->unique()
                //             ->required(),

                //         TextInput::make('phone')
                //             ->label(__('filament-panels::pages/user.phone'))
                //             ->tel()
                //             ->unique()
                //             ->required(),

                //         TextInput::make('address')
                //             ->label(__('filament-panels::pages/user.address')),

                //         FileUpload::make('image')
                //             ->label(__('filament-panels::pages/user.image'))
                //             ->disk('public')
                //             ->directory('users/images')
                //             ->image()
                //             ->visibility('public')
                //             ->columnSpanFull()
                //             ->imageEditor(),

                //     ]),

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
                    ->formatStateUsing(fn($state, $record) => __('filament-panels::pages/user.' . $state))
                    ->sortable()
                    ->searchable(),


            ])
            ->filters([
                SelectFilter::make('role')
                    ->label(__('filament-panels::pages/user.role'))
                    ->options(fn() => collect(RoleEnum::cases())->mapWithKeys(fn($role) => [
                        $role->value => $role->getLabel(),
                    ])->toArray())
                    ->query(function ( $query, array $data) {
                        if (!empty($data['value'])) {
                            $query->whereHas('roles', fn($q) => $q->where('name', $data['value']));
                        }
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                //  WalletAction::make('wallet'),
                WalletAction::make('wallet')
                    ->visible(
                        fn($record) =>
                        auth()->user()->hasRole(RoleEnum::ADMIN->value) ||
                            $record->hasRole(RoleEnum::TEACHER->value)
                    )
                    ->label(__('filament-panels::pages/user.wallet'))
                    ->icon('heroicon-o-wallet')
                    ->color('success'),
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
