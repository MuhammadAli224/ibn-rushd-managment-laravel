<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            "price" => $this->price,
            "cost" => $this->cost,
            "unit" => $this->unit,
            "image" => $this->image,
            "product_no" => $this->product_no,
            "category" => [
                'id' => $this->category_id,
                'name' => $this->category->name,

            ],
            "payment_type" => $this->payment_type,
            'branches' => $this->branches->map(function ($branch) {
                return [
                    'branch_id' => (int) $branch->id,
                    'branch_name' => $branch->name,
                    'owner' => [
                        'id' => (int) $branch->user_id,
                        'name' => $branch->owner->name,
                    ],
                    'product_info' => [
                        'quantity' => (int) $branch->pivot->quantity,
                        'price' => (float) $branch->pivot->price,
                        'status' => $branch->pivot->status,
                        'is_active' => (bool) $branch->pivot->is_active,
                        'is_most_popular' => (bool) $branch->pivot->is_most_popular,
                
                    ],

                ];
            }),



        ];
    }
}
