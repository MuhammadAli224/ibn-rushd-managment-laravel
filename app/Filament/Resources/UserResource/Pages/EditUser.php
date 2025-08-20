<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->visible(
                    fn() =>
                    auth()->user()->hasRole(\App\Enums\RoleEnum::ADMIN->value) &&
                        ! $this->record->is_super_admin &&
                        auth()->user()->id !== $this->record->id
                ),
        ];
    }
}
