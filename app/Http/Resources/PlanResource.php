<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlanResource extends JsonResource
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
            "description" => $this->description,
            "monthly_price" => $this->monthly_price,
            "yearly_price" => $this->yearly_price,
            "connect_zatca_1" => $this->connect_zatca_1,
            "connect_zatca_2" => $this->connect_zatca_2,
            "devices_limit" => $this->devices_limit,
            "branches_limit" => $this->branches_limit,
            "users_limit" => $this->users_limit,
            "invoices_limit" => $this->invoices_limit, 
            "product_limit" => $this->product_limit,
            "reports" => $this->reports,
            "supported_printers" =>$this->supported_printers,
            "is_default" => $this->is_default,
            "is_trial" => $this->is_trial,
            "trial_days" => $this->trial_days,
            "is_recommended" => $this->is_recommended,



        ];
    }
}
