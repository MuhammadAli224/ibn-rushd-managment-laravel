<?php

namespace App\Filament\Resources;


use App\Enums\RoleEnum;
use App\Filament\Actions\OneSignalNotificationAction;
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
use Illuminate\Database\Eloquent\Builder;

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

    public static function getEloquentQuery(): Builder
    {
        $user = auth()->user();

        if ($user->hasRole(RoleEnum::ADMIN->value)) {
            return parent::getEloquentQuery()
                ->where(function ($query) {
                    $query->where('email', '!=', 'muhammad@admin.com')
                        ->orWhereNull('email');
                });
        } else {
            return parent::getEloquentQuery()
                ->where('id', $user->id);
        }
    }

    public static function getNavigationBadge(): ?string
    {
        $user = auth()->user();

        if ($user->hasRole(RoleEnum::ADMIN->value)) {
            return static::getModel()::where(function ($q) {
                $q->where('is_super_admin', '!=', 1)
                    ->orWhereNull('is_super_admin');
            })->count();
        }



        return "1";
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


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->poll('10s')
            ->columns([
                TextColumn::make('name')
                    ->label(__('filament-panels::pages/user.name'))
                    ->sortable()
                    ->searchable(),
                ImageColumn::make('image')
                    ->label(__('filament-panels::pages/user.image'))
                    ->disk('public')
                    ->getStateUsing(function ($record) {
                        if (!$record->image) {
                            return asset('images/default-avatar.png');
                        }

                        return filter_var($record->image, FILTER_VALIDATE_URL)
                            ? $record->image
                            : asset('storage/' . $record->image);
                    })
                    ->square()
                    ->height(50)
                    ->circular(),


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
                    ->query(function ($query, array $data) {
                        if (!empty($data['value'])) {
                            $query->whereHas('roles', fn($q) => $q->where('name', $data['value']));
                        }
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                OneSignalNotificationAction::make('notification')
                    ->visible(fn($record) => filled($record->onesignal_token))
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
