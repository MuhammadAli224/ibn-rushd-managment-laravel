<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubsecriptionResource extends JsonResource
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
           "user" => $this->user->name,
            "plan" => $this->plan->name,
            "starts_at" => $this->starts_at,
            "end_at" => $this->end_at,
            "is_active" => $this->is_active,
            "price" => $this->price,
            "is_trial" => $this->is_trial,
            "connect_zatca_1" => $this->connect_zatca_1,
            "connect_zatca_2" => $this->connect_zatca_2,
            "devices_limit" => $this->devices_limit,
            "users_limit" => $this->users_limit,
            "branches_limit" => $this->branches_limit,
            "product_limit" => $this->product_limit,
            "invoices_limit" => $this->invoices_limit,
            "supported_printers" => $this->supported_printers,
            "duration_days" => $this->duration_days,
        

        ];
    }
}
