<?php

namespace App\Filament\Resources\TeacherResource\Pages;

use App\Enums\RoleEnum;
use App\Filament\Resources\TeacherResource;
use App\Models\Subject;
use App\Models\User;
use Filament\Actions;
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
            try {
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
                if (isset($data['user']['subjects']) && !empty($data['user']['subjects'])) {
                    $subjects = Subject::whereIn('id', $data['user']['subjects'])->get();
                    $user->subjects()->attach($subjects);
                }
                $data['user_id'] = $user->id;
                $user->assignRole(RoleEnum::TEACHER->value);

                return static::getModel()::create($data);
            } catch (\Exception $e) {
                Log::error('Error creating teacher: ' . $e->getMessage());

                throw $e;
            }
        });
    }
}


