<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OurClientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'logo' => $this->image_url,
            'email' => $this->email,
            'phone' => $this->phone,
            'facebook' => $this->facebook,
            'tiktok' => $this->tiktok,
            'snapchat' => $this->snapchat,
            'twitter' => $this->twitter,
            'instagram' => $this->instagram,
            'website' => $this->website,
            'whatsapp' => $this->whatsapp,
            


        ];
    }
}
