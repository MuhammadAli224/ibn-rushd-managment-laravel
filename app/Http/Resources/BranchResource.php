<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BranchResource extends JsonResource
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
            "owner" => [
                
                "id" => $this->user_id,
                "name" => $this->owner->name,

            ],
            "tax_number" => $this->tax_number,
            "comerical_number" => $this->comerical_number,
            "zip_code" => $this->zip_code,
            "street" => $this->street,
            "city" => $this->city->name,
            "district" => $this->district->name,
            "building_number" => $this->building_number,
            "secondary_number" => $this->secondary_number,
            "image" => $this->image,
            

        ];
    }
}
