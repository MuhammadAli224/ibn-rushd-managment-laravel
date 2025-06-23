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
            "fcm_token" => $this->fcm_token,

            $this->mergeWhen($this->isOwner(), [
                "comerical_number" => $this->comerical_number,
                "tax_number" => $this->tax_number,
                'branches' => $this->ownedBranches()->active()->get()->count() ?? 0,
                'subscription' => new SubsecriptionResource($this->subscriptions()->active()->first()),


            ],),
            $this->mergeWhen($this->isBranchUser(), [

                'user_branches' => BranchResource::collection($this->branches),

            ],),
            'permissions' => $this->permissions?->pluck('name')->toArray() ?? [],
            'roles' => $this->roles?->pluck('name')->first() ?? [],




        ];
    }
}
