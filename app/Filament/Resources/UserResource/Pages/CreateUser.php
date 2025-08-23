<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Enums\RoleEnum;
use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Spatie\Permission\Contracts\Role;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;
    protected function afterCreate(): void
    {
        $user = $this->record;
        if ($user->hasAnyRole([RoleEnum::TEACHER->value,  RoleEnum::GUARDIAN->value, RoleEnum::DRIVER->value])) {

            $user->createWallet([
                'name' => 'Default Wallet',
                'slug' => 'default',
                'balance' => 0,


            ]);
        }

        $this->dispatch('refresh');
    }
}
