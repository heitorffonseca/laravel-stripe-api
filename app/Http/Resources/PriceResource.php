<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Stripe\Price;

class PriceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var Price $this */
        return [
            'id' => $this->id,
            'billing_scheme' => $this->billing_scheme,
            'unit_amount' => $this->unit_amount,
            'type' => $this->type
        ];
    }
}
