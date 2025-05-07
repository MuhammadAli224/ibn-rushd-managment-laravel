<?php

namespace App\Filament\Resources\DriverResource\Pages;

use App\Enums\RoleEnum;
use App\Filament\Resources\DriverResource;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CreateDriver extends CreateRecord
{
    protected static string $resource = DriverResource::class;
    protected function handleRecordCreation(array $data): Model
    {
        $validatedUserData = Validator::make($data['user'], [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20|unique:users,phone',
            'password' => 'required|min:8',
            'national_id' => 'required|string|max:255|unique:users,national_id',
            'gender' => 'required|string',
            'country' => 'required|string',
            'image' => 'nullable|string',
            'center_id' => 'required|exists:centers,id',
        ])->validate();
        return DB::transaction(function () use ($data, $validatedUserData) {
            try{
                $user = User::create([
                    'name' => $validatedUserData['name'],
                    'email' => $validatedUserData['email'],
                    'phone' => $validatedUserData['phone'],
                    'password' => Hash::make($validatedUserData['password']),
                    'national_id' => $validatedUserData['national_id'],
                    'center_id' => $validatedUserData['center_id'],
                    'gender' => $validatedUserData['gender'],
                    'country' => $validatedUserData['country'],
                    'image' => $validatedUserData['image']
                ]);
                $data['user_id'] = $user->id;
                $user->assignRole(RoleEnum::DRIVER->value);

                return static::getModel()::create($data);
            } catch (\Exception $e) {
                Log::error('Error creating Driver: ' . $e->getMessage());

                throw $e;
            }
        });
    }
}
