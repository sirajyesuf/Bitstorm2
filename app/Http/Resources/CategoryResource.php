<?php

namespace App\Http\Resources;

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
        return  [
            'id' => $this->id,
            'name' => $this->name,
            'banner' => 'banner',
            'icon' => 'icon',
            'number_of_children' => 0,
            'products' => url(route('products.category',['id' => $this->id])),
        ];
    }
}
