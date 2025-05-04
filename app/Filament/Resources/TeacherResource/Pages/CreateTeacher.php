<?php

namespace App\Filament\Resources\TeacherResource\Pages;

use App\Filament\Resources\TeacherResource;
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
    // Validate user data first
    $validatedUserData = Validator::make($data['user'], [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'phone' => 'required|string|max:20',
        'password' => 'required|min:8',
        'national_id' => 'required|string|max:255|unique:users,national_id',
    ])->validate();

    // Use database transaction for atomic operations
    return DB::transaction(function () use ($data, $validatedUserData) {
        // Create user
        $user = User::create([
            'name' => $validatedUserData['name'],
            'email' => $validatedUserData['email'],
            'phone' => $validatedUserData['phone'],
            'password' => Hash::make($validatedUserData['password']),
            'national_id' => $validatedUserData['national_id'],
            'center_id'=>\auth()->user()->center->id
        ]);

        // Assign the user ID to the teacher record
        $data['user_id'] = $user->id;

        // Create and return the teacher record
        return static::getModel()::create($data);
    });
}
}
