<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BrandResource extends JsonResource
{
   
    
    public function toArray(Request $request): array
    {
        return 
        [
            'id'  => $this->id,
            'name' => $this->name,
            'image' => asset('storage/'.$this->image),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'products' => url(route('products.brand',['id' => $this->id])),

        ];
    }
}
