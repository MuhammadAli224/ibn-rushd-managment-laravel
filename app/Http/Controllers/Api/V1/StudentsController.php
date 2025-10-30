<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Enums\GenderEnum;
use App\Enums\RoleEnum;
use App\Models\Guardian;
use App\Models\User;
use App\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StudentsController extends Controller
{
    use ApiResponseTrait;

    public function store(Request $request)
    {
        $validated = $request->validate([
            'guardian_id' => ['required', 'exists:guardians,id'],
            'name'        => ['required', 'string', 'max:255'],
            'class'       => ['required', 'string', 'max:255'],
            'phone'       => ['nullable', 'string', 'max:20'],
            'address'     => ['nullable', 'string', 'max:255'],
        ]);

        DB::beginTransaction();

        try {
            // ✅ Create the student
            $student = \App\Models\Student::create([
                'guardian_id' => $validated['guardian_id'],
                'name'        => $validated['name'],
                'class'       => $validated['class'],
                'phone'       => $validated['phone'] ?? null,
                'address'     => $validated['address'] ?? null,
            ]);

            DB::commit();

            return $this->success(
                data: $student->load('guardian'),
                message: __('general.create_success') // same style as your GuardianController
            );
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error in StudentController store: ' . $e->getMessage());

            return $this->error(
                message: __('general.create_failed'),
                error: $e->getMessage(),
                statusCode: 500
            );
        }
    }
}
