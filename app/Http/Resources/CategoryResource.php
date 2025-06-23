<?php

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            "name_ar" => $this->getTranslation('name', 'ar'),
            "name_en" => $this->getTranslation('name', 'en'),
            'branches' => $this->branches->map(function ($branch) {
                return [
                    'branch_id' => (int) $branch->id,
                    'branch_name' => $branch->name,
                    'owner' => [
                        'id' => (int) $branch->user_id,
                        'name' => $branch->owner->name,
                    ],
                ];
            }),

            "is_primary" => $this->is_primary,
       
        ];
    }
}
