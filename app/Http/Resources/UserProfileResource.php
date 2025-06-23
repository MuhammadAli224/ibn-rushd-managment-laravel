<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "email" => $this->email,
            "phone" => $this->phone,
            "address" => $this->address,
            "image" => $this->image,
            "status" => $this->status,
            "gender" => $this->gender,
            "center_id" => $this->center_id,
            "country" => $this->country,
            "national_id" => (int)$this->national_id,
            "is_active" => $this->is_active,
            "fcm_token" => $this->fcm_token,
            'permissions' => $this->permissions?->pluck('name')->toArray() ?? [],
            'roles' => $this->roles?->pluck('name')->first() ?? [],
        ];
    }
}
