<?php

namespace App\Http\Resources;

use App\Models\Product;
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
        /** @var Product $this */
        return [
            'id' => $this->sid,
            'name' => $this->name,
            'description' => $this->description,
            'price' => new PriceResource($this->price),
            'active' => $this->active
        ];
    }
}
