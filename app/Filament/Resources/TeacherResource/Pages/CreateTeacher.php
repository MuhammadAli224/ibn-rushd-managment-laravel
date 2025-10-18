<?php

namespace App\Filament\Resources\TeacherResource\Pages;

use App\Enums\RoleEnum;
use App\Filament\Resources\TeacherResource;
use App\Models\User;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CreateTeacher extends CreateRecord
{
    protected static string $resource = TeacherResource::class;


    protected function handleRecordCreation(array $data): Model
    {
        $validatedUserData = Validator::make($data['user'], [
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:users,email',
            'phone' => 'required|string|max:20|unique:users,phone',
            'password' => 'required|min:8',
            'national_id' => 'nullable|string|max:255|unique:users,national_id',
            'gender' => 'required|string',
            'country' => 'required|string',
            'image' => 'nullable|string',
            'center_id' => 'required|exists:centers,id',
        ])->validate();
        $validatedUserData['phone'] = $this->normalizePhone($validatedUserData['phone']);

        return DB::transaction(function () use ($data, $validatedUserData) {
            try {
                Log::info('Creating teacher with data: ', $data);
                $user = User::create([
                    'name' => $validatedUserData['name'],
                    'email' => $validatedUserData['email'] ?? null,
                    'phone' => $validatedUserData['phone'],
                    'password' => $validatedUserData['password'],
                    'national_id' => $validatedUserData['national_id'] ?? null,
                    'center_id' => $validatedUserData['center_id'],
                    'gender' => $validatedUserData['gender'],
                    'country' => $validatedUserData['country'],
                    'image' => $validatedUserData['image'] ?? null
                ]);

                $data['user_id'] = $user->id;
                $user->assignRole(RoleEnum::TEACHER->value);

                return static::getModel()::create($data);
            } catch (\Exception $e) {
                Log::error('Error creating teacher: ' . $e->getMessage());

                throw $e;
            }
        });
    }


    private function normalizePhone(string $phone): string
    {
        $phone = preg_replace('/\D/', '', $phone); // remove any non-digit characters

        if (str_starts_with($phone, '00') && !str_starts_with($phone, '00974')) {
            return '00974' . substr($phone, 2);
        }

        if (str_starts_with($phone, '0') && !str_starts_with($phone, '00974')) {
            return '00974' . ltrim($phone, '0');
        }

        return $phone;
    }
}
