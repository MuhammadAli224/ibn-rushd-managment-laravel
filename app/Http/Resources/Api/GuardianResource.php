<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GuardianResource extends JsonResource
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
            "name" => $this->user->name,
            "email" => $this->user->email,
            "phone" => $this->user->phone,
            "address" => $this->user->address,
            "children" => $this->students,


        ];
    }
}
